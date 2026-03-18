<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    // ----------------------------------------------------------------------
    // 1. HALAMAN "PERMOHONAN PEMBELIAN" (indexRequests)
    // Aturan: Menampilkan data ketika status != 'approved'
    // ----------------------------------------------------------------------
    public function indexRequests(Request $request)
    {
        // Mulai Query (Gunakan Load Partial untuk Items jika dibutuhkan, tapi untuk master cukup ini dulu)
        $query = Purchase::with(['user', 'vendor', 'items.category']);

        // LOGIKA MULTI-ROLE FILTERING
        // -------------------------------------------------------------
        $userRole = Auth::user()->role;

        if ($userRole == 'staff') {
            // Staff melihat SEMUA pengajuannya sendiri, kecuali yang sudah dibelikan/selesai
            // Atau melihat semua riwayat pending/rejected
            $query->where('user_id', Auth::id())
                  ->where('status', '!=', 'completed');
        } elseif ($userRole == 'kepala') {
            // Kepala melihat SEMUA pengajuan yang masih menunggu persetujuannya (pending_head)
            // Dan pengajuan yang dia tolak (rejected_head) sbg riwayat
            $query->whereIn('status', ['pending_head', 'rejected_head']);
        } elseif ($userRole == 'bendahara') {
            // Bendahara HANYA melihat pengajuan yang SUDAH DISETUJUI kepala (approved_head)
            // Dan mungkin yang dia tolak (rejected_bendahara)
            $query->whereIn('status', ['approved_head', 'rejected_bendahara']);
        }

        // --- FILTER 1: SEARCH (Kode Purchase) ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // --- FILTER 2: STATUS KHUSUS ---
        if ($request->filled('status') && $request->status !== 'all') {
            // Jika Kepala/Bendahara ingin filter spesifik
            $query->where('status', $request->status);
        }

        // --- FILTER 3: TANGGAL ---
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Eksekusi dengan Pagination
        $purchases = $query->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        // STATISTICS (REQUEST PAGE)
        // Disesuaikan berdasarkan role
        if ($userRole == 'kepala') {
            $pendingRequests = Purchase::where('status', 'pending_head')->count();
            $rejectedRequests = Purchase::where('status', 'rejected_head')->count();
        } elseif ($userRole == 'bendahara') {
            $pendingRequests = Purchase::where('status', 'approved_head')->count();
            $rejectedRequests = Purchase::where('status', 'rejected_bendahara')->count();
        } else {
            $pendingRequests = Purchase::where('user_id', Auth::id())->whereIn('status', ['pending_head', 'approved_head', 'pending_bendahara'])->count();
            $rejectedRequests = Purchase::where('user_id', Auth::id())->whereIn('status', ['rejected_head', 'rejected_bendahara'])->count();
        }

        return view('purchases.requests', compact('purchases', 'pendingRequests', 'rejectedRequests'));
    }

    // (indexTransaction dihapus karena sudah tidak relevan dengan alur baru)

    // ----------------------------------------------------------------------
    // 3. HALAMAN RIWAYAT (indexHistory)
    // Menampilkan yang sudah selesai (is_purchased = true) atau History Rejected
    // ----------------------------------------------------------------------
    public function indexHistory(Request $request)
    {
        $query = Purchase::with(['vendor', 'user', 'items.category']);

        // --- FILTER 1: STATUS ---
        // Logika: 
        // 1. Jika pilih 'completed' -> cari yang is_purchased = true
        // 2. Jika pilih 'rejected'  -> cari yang status = rejected
        // 3. Jika kosong/all      -> cari keduanya (OR)
        
        if ($request->filled('status') && $request->status == 'completed') {
            $query->where('is_purchased', true);
        } 
        elseif ($request->filled('status') && $request->status == 'rejected') {
            $query->where('status', 'rejected');
        } 
        else {
            // Default: Tampilkan Keduanya (Selesai ATAU Ditolak)
            $query->where(function($q) {
                $q->where('is_purchased', true)
                  ->orWhere('status', 'rejected');
            });
        }

        // --- FILTER 2: SEARCH ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhere('tool_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('vendor', function($v) use ($search) {
                      $v->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // --- FILTER 3: BULAN ---
        if ($request->filled('month')) {
            $query->whereMonth('updated_at', $request->month);
        }

        // --- FILTER 4: TAHUN ---
        if ($request->filled('year')) {
            $query->whereYear('updated_at', $request->year);
        }

        $history = $query->orderBy('updated_at', 'desc')
                         ->paginate(5)
                         ->withQueryString();

        // STATISTICS (HISTORY PAGE)
        $completedPurchases = Purchase::where('is_purchased', true)->count();
        
        // Menghitung total expense dari barang yang sudah dibeli (completed)
        // Kita gunakan subtotal yang sudah diupdate dengan harga realisasi (jika ada logic update subtotal waktu completed)
        // Atau hitung manual: quantity * actual_unit_price (jika disimpan)
        // Tapi di controller storeEvidence ada logic: $purchase->subtotal = $request->real_price * $purchase->quantity;
        // Jadi aman pakai sum('subtotal') untuk yang is_purchased=true.
        $totalExpense = Purchase::where('is_purchased', true)->sum('subtotal');

        return view('purchases.history', compact('history', 'completedPurchases', 'totalExpense'));
    }

    /**
     * [BARU] Export Excel untuk Halaman Request (Pengajuan)
     */
    public function exportRequestExcel(Request $request) 
    {
        $query = Purchase::with(['vendor', 'user', 'items.category']);

        // --- FILTER (Replikasi Logic requestList) ---
        
        // 1. STATUS
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 2. SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhere('tool_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('vendor', function($v) use ($search) {
                      $v->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $query->orderBy('created_at', 'desc');

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PurchaseRequestExport($query),
            'laporan-pengajuan-request-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportRequestPdf(Request $request) 
    {
        set_time_limit(300);
        $query = Purchase::with(['vendor', 'user', 'items.category']);

        // 1. STATUS
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 2. SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhere('tool_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('vendor', function($v) use ($search) {
                      $v->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $purchases = $query->orderBy('created_at', 'desc')->get();
        // Assuming view exists
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('purchases.requests_pdf', compact('purchases'));

        while (ob_get_level()) {
            ob_end_clean();
        } 
        return $pdf->download('laporan-pengajuan-request-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * [BARU] Export Excel Riwayat Pembelian (Audit)
     */
    public function exportHistoryExcel(Request $request)
    {
        // Langsung oper semua filter ke Class Export
        // Biar class Export yang handle logic 2 sheet terpisah (Success & Rejected)
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PurchaseHistoryExport($request->all()), 
            'laporan-pengadaan-audit-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    // ----------------------------------------------------------------------
    // CREATE & STORE (Pengajuan Baru)
    // ----------------------------------------------------------------------
    public function create()
    {
        $vendors = Vendor::all();
        $categories = Category::all(); 
        
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala', 'head'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Kepala tidak membuat pengajuan.');
        }
        
        return view('purchases.create', compact('vendors', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Header & Detail Array
        $request->validate([
            'date'                  => 'required|date',
            'vendor_id'             => 'nullable|exists:vendors,id', // Opsional, bisa pakai vendor yang disarankan atau null
            'items'                 => 'required|array|min:1',
            'items.*.category_id'   => 'required|exists:tool_categories,id',
            'items.*.tool_name'     => 'required|string',
            'items.*.specification' => 'nullable|string',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.unit_price'    => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 2. Hitung Grand Total dari seluruh item
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += ($item['quantity'] * $item['unit_price']);
            }

            // 3. Simpan Master Purchase
            $purchase = Purchase::create([
                'purchase_code' => 'REQ-' . date('ymd') . '-' . rand(1000, 9999),
                'date'          => $request->date,
                'vendor_id'     => $request->vendor_id, 
                'user_id'       => Auth::id(),
                'total_amount'  => $grandTotal,
                'status'        => 'pending_head', // Default Pending Kepala
                'is_purchased'  => false,
            ]);

            // 4. Simpan Detail Purchase Items
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];

                $purchase->items()->create([
                    'category_id'   => $item['category_id'],
                    'tool_name'     => $item['tool_name'],
                    'specification' => $item['specification'] ?? '-',
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $item['unit_price'],
                    'subtotal'      => $subtotal,
                ]);
            }

            DB::commit();
            return redirect()->route('purchases.request')->with('success', 'Pengajuan pengadaan berhasil dibuat dan menunggu persetujuan Kepala Multimedia.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['msg' => 'Gagal menyimpan pengajuan: ' . $e->getMessage()]);
        }
    }

    // ----------------------------------------------------------------------
    // ACTION: APPROVE & REJECT MULTI-LEVEL
    // ----------------------------------------------------------------------
    public function approve($id)
    {
        $user = Auth::user();
        $purchase = Purchase::findOrFail($id);

        if ($user->role == 'kepala' && $purchase->status == 'pending_head') {
            // Kepala menyetujui -> diteruskan ke Bendahara
            $purchase->update(['status' => 'approved_head']);
            return redirect()->back()->with('success', 'Pengajuan disetujui (Kepala) dan diteruskan ke Bendahara.');
        } 
        elseif ($user->role == 'bendahara' && $purchase->status == 'approved_head') {
            // Bendahara menyetujui -> masuk ke daftar Pencairan Dana / Pembelian
            // Disini status belum "completed", tapi "pending_purchased" atau tetap "approved_head" dg flag uang cair
            // Kita gunakan 'approved_head' tapi role Bendahara di frontend akan punya tombol 'Proses Cairkan' yg nnti memanggil storePurchaseEvidence
            return redirect()->back()->with('info', 'Approval Bendahara dilakukan pada saat pencairan langsung (Upload Bukti).');
        }

        return abort(403, 'Unauthorized Action or Invalid State');
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        $purchase = Purchase::findOrFail($id);

        if ($user->role == 'kepala' && $purchase->status == 'pending_head') {
            $purchase->update([
                'status' => 'rejected_head',
                'rejection_note' => $request->input('note', '-')
            ]);
            return redirect()->back()->with('success', 'Pengajuan ditolak oleh Kepala Multimedia.');
        } 
        elseif ($user->role == 'bendahara' && $purchase->status == 'approved_head') {
            $purchase->update([
                'status' => 'rejected_bendahara',
                'rejection_note' => $request->input('note', '-')
            ]);
            return redirect()->back()->with('success', 'Pengajuan ditolak oleh Bendahara (Tidak Ada Anggaran).');
        }

        return abort(403);
    }

    // ----------------------------------------------------------------------
    // 4. ACTION: UPLOAD BUKTI (Eksekusi Akhir Bendahara)
    // Aturan: Input 'transaction_proof_photo' -> 'is_purchased' = true -> Masuk Data Barang
    // ----------------------------------------------------------------------
    public function storePurchaseEvidence(Request $request, $id)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'proof_photo' => 'required|image|max:2048',
            'real_price'  => 'required|numeric', // Total Pencairan Keseluruhan
            'brand'       => 'required|string|max:100', // Merk default jika ada
        ]);

        $purchase = Purchase::with('items.category')->findOrFail($id);

        if ($request->hasFile('proof_photo')) {
            $path = $request->file('proof_photo')->store('proofs', 'public');
            $purchase->transaction_proof_photo = $path;
        }

        // 2. SIMPAN HARGA REALISASI (Optional, disimpan sbg total realisasi)
        $purchase->total_amount = $request->real_price; 
        
        $purchase->status = 'completed';
        $purchase->is_purchased = true;
        $purchase->save();

        // 3. GENERATOR ASET PER ITEM
        // Looping setiap item yang ada di Transaksi Purchase ini
        foreach ($purchase->items as $item) {
            
            $prefix = 'GEN'; 
            if ($item->category && !empty($item->category->category_name)) {
                $prefix = strtoupper(substr($item->category->category_name, 0, 3));
            }

            // Loop sebanyak quantity per item (Misal beli 3 Lensa, buat 3 kode)
            for ($i = 0; $i < $item->quantity; $i++) {
                
                // Cari Nomor Terakhir
                $lastTool = Tool::where('tool_code', 'like', $prefix . '-%')->orderBy('id', 'desc')->first();
                $nextNumber = 1;
                if ($lastTool) {
                    $parts = explode('-', $lastTool->tool_code);
                    if (count($parts) >= 2) {
                        $nextNumber = intval(end($parts)) + 1;
                    }
                }
                $generatedCode = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                // INSERT KE TOOLS
                Tool::create([
                    'tool_code'           => $generatedCode,
                    'tool_name'           => $item->tool_name,
                    'brand'               => $request->brand,       // Sama rata brand
                    'purchase_date'       => $purchase->date,       // DARI TANGGAL BELI MASTER
                    'category_id'         => $item->category_id,
                    'purchase_item_id'    => $purchase->id,         // Track dari master purchase
                    'current_condition'   => 'Baik',
                    'availability_status' => 'available',
                ]);
            }
        }

        return redirect()->route('purchases.request')->with('success', 'Transaksi Selesai! Anggaran dicairkan dan barang masuk inventaris.');
    }

    public function show($id)
    {
        $purchase = Purchase::with(['vendor', 'user', 'items.category'])->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        
        if (in_array($purchase->status, ['approved_head', 'completed']) || $purchase->is_purchased) {
             return back()->with('error', 'Tidak bisa menghapus data yang sudah disetujui/diselesaikan.');
        }

        $purchase->delete();
        return back()->with('success', 'Data dihapus.');
    }

    // (Fungsi process() dihapus karena tugasnya sudah digabung ke storePurchaseEvidence)

    /**
     * [BARU] Export PDF History with Analysis
     */
    public function exportHistoryPdf(Request $request)
    {
        set_time_limit(300);
        // 1. LOGIKA QUERY (Disamakan pesis dengan indexHistory)
        $query = Purchase::with(['vendor', 'user', 'items.category']);

        // Filter Status Defaul (Completed / Rejected)
        if ($request->filled('status') && $request->status == 'completed') {
            $query->where('is_purchased', true);
        } 
        elseif ($request->filled('status') && $request->status == 'rejected') {
            $query->where('status', 'rejected');
        } 
        else {
            // Default: Tampilkan Keduanya (Selesai ATAU Ditolak)
            $query->where(function($q) {
                $q->where('is_purchased', true)
                  ->orWhere('status', 'rejected');
            });
        }

        // ... FILTERING LAIN ...
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhere('tool_name', 'LIKE', "%{$search}%");
            });
        }
        if ($request->filled('month')) {
            $query->whereMonth('updated_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('updated_at', $request->year);
        }

        $purchases = $query->orderBy('updated_at', 'desc')->get();

        // 2. GENERATE LOGO BASE64
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

        // 3. RENDER PDF (PORTRAIT)
        try {
            // AGGRESSIVE BUFFER CLEAN
            while (ob_get_level()) {
                ob_end_clean();
            }
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('purchases.history_pdf', compact('purchases', 'logo'));
            // $pdf->setPaper('a4', 'landscape'); // REMOVED: User request Portrait
            return $pdf->download('laporan-riwayat-pengadaan-' . now()->format('Y-m-d') . '.pdf');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Gagal export PDF: ' . $e->getMessage()], 500);
        }
    }
}