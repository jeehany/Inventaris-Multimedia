<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\Borrower;
use App\Models\Maintenance;
use App\Models\Category;
use App\Models\MaintenanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\BorrowingExport; // <--- TAMBAHAN PENTING

class BorrowingController extends Controller
{
    /**
     * Menampilkan daftar peminjaman dengan fitur Filter & Search
     */
    public function index(Request $request)
    {
        $query = $this->getFilteredQuery($request);

        $borrowings = $query->with(['borrower', 'items.tool', 'user'])
                            ->latest()
                            ->paginate(5);        

        // [BARU] Ambil jenis maintenance buat dropdown
        $maintenanceTypes = MaintenanceType::all(); 

        // STATISTICS
        $activeBorrowings = Borrowing::where('borrowing_status', 'active')->count();
        $returnedBorrowings = Borrowing::where('borrowing_status', 'returned')->count();
        $overdueBorrowings = Borrowing::where('borrowing_status', 'active')
                                      ->where('planned_return_date', '<', now()->startOfDay())
                                      ->count();

        // [UBAH] Tambahkan compact 'maintenanceTypes'
        return view('borrowings.index', compact('borrowings', 'maintenanceTypes', 'activeBorrowings', 'returnedBorrowings', 'overdueBorrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $borrowers = Borrower::all();
        // Only show available tools
        $tools = Tool::where('availability_status', 'available')->orderBy('tool_name')->get(); 
        $categories = Category::all(); // <--- ADDED

        $nextCode = 'BRW-' . date('Ymd') . '-' . rand(100, 999); // Simple generator

        return view('borrowings.create', compact('borrowers', 'tools', 'categories', 'nextCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            // 'borrowing_code' => 'required|unique:borrowings,borrowing_code', // Auto-generated now
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'tool_ids' => 'required|array',
            'tool_ids.*' => 'exists:tools,id',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Generate Code Automatically
            $generatedCode = 'BRW-' . date('Ymd') . '-' . rand(100, 999);

            $borrowing = Borrowing::create([
                'borrowing_code' => $generatedCode,
                'borrower_id' => $request->borrower_id,
                'user_id' => auth()->id(),
                'borrow_date' => $request->borrow_date,
                'planned_return_date' => $request->return_date,
                'borrowing_status' => 'active', // Langsung aktif saat barang di-scan Admin/Staff
                'notes' => $request->notes,
            ]);

            foreach ($request->tool_ids as $toolId) {
                // Create item record
                // Assuming BorrowingItem model exists and has correct fields
                \App\Models\BorrowingItem::create([
                    'borrowing_id' => $borrowing->id,
                    'tool_id' => $toolId,
                    'tool_condition_before' => 'baik', // Default, or fetch from tool
                ]);

                // Update tool status
                $tool = Tool::find($toolId);
                $tool->update(['availability_status' => 'borrowed']);
            }
        });

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['items.tool', 'borrower', 'user']);
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        if ($borrowing->borrowing_status == 'returned') {
            return redirect()->route('borrowings.index')->with('error', 'Transaksi yang sudah kembali tidak dapat diedit.');
        }

        $borrowers = Borrower::all();
        $tools = Tool::all(); // Show all in case we need to see what was there? Or just current items.
        // Complex logic needed for editing items (removing/adding). 
        // For simplified restoration, we might stick to basic updates or redirect if too complex for generic restore.
        
        return view('borrowings.edit', compact('borrowing', 'borrowers', 'tools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        // Handle "Return" action or generic update
        if ($request->has('action') && $request->action == 'return') {
            return $this->processReturn($request, $borrowing);
        }

        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'return_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $borrowing->update($request->only('borrower_id', 'return_date', 'notes'));

        return redirect()->route('borrowings.index')->with('success', 'Data peminjaman diperbarui.');
    }

    /**
     * [ACTION] Approve Pinjaman (Otomatis Active)
     */
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if (Auth::user()->role == 'kepala' && $borrowing->borrowing_status == 'pending_head') {
            $borrowing->update(['borrowing_status' => 'active']);
            return redirect()->back()->with('success', 'Peminjaman disetujui. Aset kini berstatus Dipinjam (Active).');
        }

        return abort(403, 'Unauthorized Action');
    }

    /**
     * [ACTION] Reject Pinjaman 
     */
    public function reject(Request $request, $id)
    {
        $borrowing = Borrowing::with('items.tool')->findOrFail($id);

        if (Auth::user()->role == 'kepala' && $borrowing->borrowing_status == 'pending_head') {
            DB::transaction(function () use ($borrowing, $request) {
                $borrowing->update([
                    'borrowing_status' => 'rejected_head',
                    'rejection_note' => $request->input('note', '-')
                ]);

                // Kembalikan status barang
                foreach ($borrowing->items as $item) {
                    if ($item->tool) {
                        $item->tool->update(['availability_status' => 'available']);
                    }
                }
            });

            return redirect()->back()->with('success', 'Peminjaman ditolak dan ketersediaan aset dikembalikan.');
        }

        return abort(403, 'Unauthorized Action');
    }

    /**
     * [ACTION] Return Borrowed Items
     */
    public function returnItem(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        return $this->processReturn($request, $borrowing);
    }

    protected function processReturn(Request $request, Borrowing $borrowing)
    {
        // Validate return details (conditions of tools)
        // This assumes the form sends item conditions
        
        DB::transaction(function () use ($borrowing, $request) {
            $borrowing->update([
                'borrowing_status' => 'returned',
                'actual_return_date' => $request->returned_at ?? now(),
                'return_condition' => $request->return_condition,
                'final_status' => $request->final_status,
            ]);

            // Update items and tools
            foreach ($borrowing->items as $item) {
                if ($item->tool) {
                    
                    // A. KASUS BARANG HILANG
                    if ($request->final_status == 'Hilang') {
                        $item->tool->update([
                            'availability_status' => 'disposed',
                            'disposal_reason'     => 'Hilang saat dipinjam (' . $borrowing->borrowing_code . ')',
                        ]);
                        $item->tool->delete(); // Soft Delete (Masuk Sampah)
                    
                    // B. KASUS BARANG DIGANTI (Ganti Rugi)
                    } elseif ($request->final_status == 'Diganti') {
                        $item->tool->update([
                            'availability_status' => 'available',
                            'current_condition'   => 'Baik', // Asumsi barang pengganti kondisinya baik
                        ]);

                    // C. KASUS NORMAL / SELESAI
                    } else {
                        // Cek Kondisi Fisik untuk Maintenance
                        if (in_array($request->return_condition, ['Rusak Ringan', 'Rusak Berat'])) {
                            // 1. Update Status Alat -> Maintenance
                            $item->tool->update([
                                'availability_status' => 'maintenance',
                                'current_condition'   => $request->return_condition, 
                            ]);

                            // 2. Cari/Buat Jenis Maintenance
                            $type = \App\Models\MaintenanceType::firstOrCreate(
                                ['name' => $request->return_condition],
                                ['description' => 'Jenis perawatan otomatis dari pengembalian peminjaman']
                            );

                            // 3. Buat Tiket Maintenance
                            \App\Models\Maintenance::create([
                                'tool_id'             => $item->tool_id,
                                'user_id'             => auth()->id(),
                                'maintenance_type_id' => $type->id,
                                'start_date'          => now(),
                                'note'                => "Auto-generated: " . $request->return_condition . " setelah peminjaman " . $borrowing->borrowing_code,
                                'status'              => 'in_progress',
                            ]);

                        } else {
                            // Jika Baik / Normal -> Kembali Available
                            $item->tool->update([
                                'availability_status' => 'available',
                                'current_condition'   => 'Baik',
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('borrowings.index')->with('success', 'Aset telah dikembalikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {
            // Restore tool status if borrowing was active
            if ($borrowing->borrowing_status == 'active') {
                foreach ($borrowing->items as $item) {
                    if ($item->tool) {
                        $item->tool->update(['availability_status' => 'available']);
                    }
                }
            }
            $borrowing->items()->delete();
            $borrowing->delete();
        });

        return redirect()->route('borrowings.index')->with('success', 'Data peminjaman dihapus.');
    }

    /**
     * [BARU] Export Laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        // 1. Gunakan logika filter yang sama
        $query = $this->getFilteredQuery($request);

        // 2. Load Relationship 'borrower' dan 'items.tool'
        $borrowings = $query->with(['borrower', 'items.tool']) 
                            ->latest()
                            ->get();

        // [FIX PDF IMAGE ROBUST] Convert Logo to Base64 with Error Handling
        try {
             $path = public_path('images/logo.png');
             if (file_exists($path)) {
                 $type = pathinfo($path, PATHINFO_EXTENSION);
                 $data = file_get_contents($path);
                 $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
             } else {
                 $logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
             }
        } catch (\Throwable $e) {
              $logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        }

        // 3. Load View PDF
        try {
            set_time_limit(300);
            while (ob_get_level()) {
                ob_end_clean();
            }
            $pdf = Pdf::loadView('borrowings.pdf', compact('borrowings', 'logo'));
            return $pdf->stream('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * [BARU] Export Laporan ke Excel
     */
    public function exportExcel(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        return Excel::download(new BorrowingExport($query), 'laporan-peminjaman-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function analysisPdf(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $borrowings = $query->with(['borrower', 'items.tool'])->get();
        
        // [FIX PDF IMAGE ROBUST] Convert Logo to Base64 with Error Handling
        try {
            $path = public_path('images/logo.png');
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
            }
        } catch (\Throwable $e) {
             $logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        }

        // Assuming analysis_pdf view exists or we use the main pdf for now if not
        try {
            if (ob_get_length()) ob_end_clean(); // [CLEAN BUFFER] Agar PDF tidak ERR_FAILED
            $pdf = Pdf::loadView('borrowings.analysis_pdf', compact('borrowings', 'logo'));
            return $pdf->stream('laporan-analisa-peminjaman-' . now()->format('Y-m-d') . '.pdf');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Gagal membuat Laporan Analisa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * [AJAX] Get Tools by Category
     */
    public function getToolsByCategory($categoryId)
    {
        $tools = Tool::where('category_id', $categoryId)
                     ->where('availability_status', 'available')
                     ->select('id', 'tool_name', 'tool_code')
                     ->orderBy('tool_name')
                     ->get();

        return response()->json($tools);
    }

    /**
     * [AJAX] Get Tool by Barcode / QR Code
     */
    public function getToolByCode(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Kode kosong!']);
        }

        $tool = Tool::with('category')->where('tool_code', $code)->first();

        if (!$tool) {
            return response()->json(['success' => false, 'message' => 'Aset tidak ditemukan.']);
        }

        if ($tool->availability_status !== 'available') {
            return response()->json([
                'success' => false, 
                'message' => 'Aset sedang tidak tersedia (Status: ' . $tool->availability_status . ').'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $tool->id,
                'tool_code' => $tool->tool_code,
                'tool_name' => $tool->tool_name,
                'category_name' => $tool->category ? $tool->category->category_name : '-',
            ]
        ]);
    }

    /**
     * [AJAX] Find Active Borrowing by Tool Barcode
     */
    public function getBorrowingByToolCode(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Kode kosong!']);
        }

        $tool = Tool::where('tool_code', $code)->first();
        if (!$tool) {
            return response()->json(['success' => false, 'message' => 'Aset tidak ditemukan di sistem.']);
        }

        // Find active borrowing containing this tool
        $borrowingItem = \App\Models\BorrowingItem::where('tool_id', $tool->id)
            ->whereHas('borrowing', function($q) {
                $q->where('borrowing_status', 'active');
            })->first();

        if (!$borrowingItem) {
            return response()->json(['success' => false, 'message' => 'Aset ini tidak sedang dipinjam saat ini.']);
        }

        return response()->json([
            'success' => true,
            'borrowing_id' => $borrowingItem->borrowing_id,
            'tool_name' => $tool->tool_name,
            'message' => 'Detail Peminjaman ditemukan!'
        ]);
    }

    /**
     * [HELPER] Fungsi Logika Filter (Dipakai oleh Index & ExportPdf)
     * Ini biar kodingan rapi dan tidak duplikat.
     */
    private function getFilteredQuery(Request $request)
    {
        $query = Borrowing::with(['borrower', 'user', 'items.tool']);

        // Logika Search
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->whereHas('borrower', function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                  ->orWhere('code', 'like', '%'.$search.'%');
            });
        }

        // Penambahan Logika Multi-Role
        $userRole = Auth::check() ? Auth::user()->role : 'staff';
        if ($userRole == 'staff') {
            $query->where('user_id', Auth::id());
        }

        // Logika Filter Status
        if ($request->has('status') && $request->status != null && $request->status != 'all') {
            $query->where('borrowing_status', $request->status);
        }

        // Filter periode
        if ($request->has('period') && $request->period != 'all') {
            if ($request->period == 'week') {
                $query->where('borrow_date', '>=', now()->subWeek());
            } elseif ($request->period == 'month') {
                $query->where('borrow_date', '>=', now()->subMonth());
            }
        }

        return $query;
    }
}