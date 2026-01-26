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
        // Mulai Query
        $query = Purchase::with(['vendor', 'user', 'category'])
            // Hanya tampilkan yang BELUM disetujui (Pending & Rejected)
            // Karena yang Approved pindah ke menu Transaksi
            ->where('status', '!=', 'approved');

        // --- FILTER 1: SEARCH (Kode / Nama Barang) ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhere('tool_name', 'LIKE', "%{$search}%");
            });
        }

        // --- FILTER 2: STATUS (Pending / Rejected) ---
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // --- FILTER 3: TANGGAL ---
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Eksekusi dengan Pagination
        $purchases = $query->orderBy('created_at', 'desc')
                           ->paginate(5)
                           ->withQueryString();

        // STATISTICS (REQUEST PAGE)
        $pendingRequests = Purchase::where('status', 'pending')->count();
        $rejectedRequests = Purchase::where('status', 'rejected')->count();

        return view('purchases.requests', compact('purchases', 'pendingRequests', 'rejectedRequests'));
    }

    // ----------------------------------------------------------------------
    // 2. HALAMAN "PEMBELIAN BARANG" (indexTransaction)
    // Aturan: Menampilkan data ketika status == 'approved'
    // ----------------------------------------------------------------------
    public function indexTransaction(Request $request)
    {
        // Query: Approved TAPI Belum Dibeli
        $query = Purchase::with(['vendor', 'user', 'category'])
            ->where('status', 'approved')
            ->where('is_purchased', false);

        // --- FILTER 1: SEARCH ---
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

        // --- FILTER 2: BULAN ---
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        // --- FILTER 3: TAHUN ---
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $purchases = $query->orderBy('date', 'asc')
                           ->paginate(5)
                           ->withQueryString();

        // STATISTICS (TRANSACTION PAGE)
        $approvedTransactions = Purchase::where('status', 'approved')->where('is_purchased', false)->count();
        $totalPlanCost = Purchase::where('status', 'approved')->where('is_purchased', false)->sum('subtotal');

        return view('purchases.transaction', compact('purchases', 'approvedTransactions', 'totalPlanCost'));
    }

    // ----------------------------------------------------------------------
    // 3. HALAMAN RIWAYAT (indexHistory)
    // Menampilkan yang sudah selesai (is_purchased = true) atau History Rejected
    // ----------------------------------------------------------------------
    public function indexHistory(Request $request)
    {
        $query = Purchase::with(['vendor', 'user', 'category']);

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
        $query = Purchase::with(['vendor', 'user', 'category']);

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
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Kepala tidak membuat pengajuan.');
        }
        
        return view('purchases.create', compact('vendors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'          => 'required|date',
            'vendor_id'     => 'required|exists:vendors,id',
            'category_id'   => 'required|exists:tool_categories,id',
            'tool_name'     => 'required|string',
            'quantity'      => 'required|integer|min:1',
            'unit_price'    => 'required|numeric|min:0',
            'specification' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = $request->quantity * $request->unit_price;

            Purchase::create([
                'purchase_code' => 'REQ-' . date('ymd') . '-' . rand(1000, 9999),
                'date'          => $request->date,
                'vendor_id'     => $request->vendor_id,
                'category_id'   => $request->category_id,
                'user_id'       => Auth::id(),
                'tool_name'     => $request->tool_name,
                'specification' => $request->specification ?? '-',
                'quantity'      => $request->quantity,
                'unit_price'    => $request->unit_price,
                'subtotal'      => $subtotal,
                'status'        => 'pending', // Default Pending
                'is_purchased'  => false,
            ]);

            DB::commit();
            return redirect()->route('purchases.request')->with('success', 'Pengajuan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // ----------------------------------------------------------------------
    // ACTION: APPROVE & REJECT
    // ----------------------------------------------------------------------
    public function approve($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['kepala','head'])) {
            return abort(403, 'Unauthorized');
        }

        $purchase = Purchase::findOrFail($id);
        
        // Hanya update status jadi Approved. 
        // Data akan pindah dari halaman Request -> Halaman Transaction
        $purchase->update([
            'status' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Pengajuan disetujui. Silakan cek menu Pembelian Barang.');
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['kepala','head'])) {
            return abort(403);
        }

        $purchase = Purchase::findOrFail($id);
        $purchase->update([
            'status' => 'rejected',
            'rejection_note' => $request->input('note', '-')
        ]);

        return redirect()->back()->with('success', 'Pengajuan ditolak.');
    }

    // ----------------------------------------------------------------------
    // 4. ACTION: UPLOAD BUKTI (Eksekusi Akhir)
    // Aturan: Input 'transaction_proof_photo' -> 'is_purchased' = true -> Masuk Data Barang
    // ----------------------------------------------------------------------
    public function storePurchaseEvidence(Request $request, $id)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'proof_photo' => 'required|image|max:2048',
            'real_price'  => 'required|numeric',
            'brand'       => 'required|string|max:100', // <--- WAJIB INPUT MERK
        ]);

        $purchase = Purchase::findOrFail($id);

        // 2. SIMPAN HARGA REALISASI & BUKTI KE PURCHASE
        if ($request->has('real_price')) {
            $purchase->unit_price = $request->real_price; 
            $purchase->subtotal = $request->real_price * $purchase->quantity;
        }

        if ($request->hasFile('proof_photo')) {
            $path = $request->file('proof_photo')->store('proofs', 'public');
            $purchase->transaction_proof_photo = $path;
        }

        $purchase->status = 'completed';
        $purchase->is_purchased = true;
        $purchase->save();

        // 3. GENERATOR KODE ASET (Sama seperti sebelumnya)
        $category = Category::find($purchase->category_id);
        $prefix = 'GEN'; 
        if ($category && !empty($category->category_name)) {
            $prefix = strtoupper(substr($category->category_name, 0, 3));
        }

        // Loop sebanyak Quantity (Misal beli 3 kamera, create 3 row di tools)
        // Atau jika sistemmu 1 row = stok banyak, sesuaikan. 
        // Di sini saya asumsikan 1 row Purchase = 1 entry Inventaris sesuai request "Detail".
        
        for ($i = 0; $i < $purchase->quantity; $i++) {
            
            // Generate Kode Unik per item
            $lastTool = Tool::where('tool_code', 'like', $prefix . '-%')->orderBy('id', 'desc')->first();
            $nextNumber = 1;
            if ($lastTool) {
                $parts = explode('-', $lastTool->tool_code);
                if (count($parts) >= 2) {
                    $nextNumber = intval(end($parts)) + 1;
                }
            }
            $generatedCode = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // 4. INSERT KE TOOLS (DENGAN DATA LENGKAP)
            Tool::create([
                'tool_code'           => $generatedCode,
                'tool_name'           => $purchase->tool_name,
                'brand'               => $request->brand,       // <--- DARI INPUT MODAL
                'purchase_date'       => $purchase->date,       // <--- DARI TANGGAL BELI
                'category_id'         => $purchase->category_id,
                'purchase_item_id'    => $purchase->id,
                'current_condition'   => 'Baik',
                'availability_status' => 'available',
            ]);
        }

        return redirect()->route('purchases.history')->with('success', 'Transaksi Selesai! Barang masuk inventaris.');
    }

    public function show($id)
    {
        $purchase = Purchase::with(['vendor', 'user', 'category'])->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        
        if ($purchase->status == 'approved' || $purchase->is_purchased) {
             return back()->with('error', 'Tidak bisa menghapus data yang sudah disetujui/dibeli.');
        }

        $purchase->delete();
        return back()->with('success', 'Data dihapus.');
    }

    public function process(Request $request, $id)
    {
        // 1. VALIDASI (Sesuaikan dengan name di Form View)
        $request->validate([
            'actual_unit_price' => 'required|numeric', // Di form namanya actual_unit_price
            'brand'             => 'required|string|max:100',
            'proof_photo'       => 'nullable|image|max:5120',
        ]);

        $purchase = Purchase::findOrFail($id);

        // 2. UPDATE DATA PURCHASE
        // Kita simpan harga asli dan ubah status
        $purchase->actual_unit_price = $request->actual_unit_price; 
        $purchase->brand = $request->brand;
        
        // Simpan Foto
        if ($request->hasFile('proof_photo')) {
            // Hapus foto lama jika ada
            if ($purchase->transaction_proof_photo) {
                Storage::disk('public')->delete($purchase->transaction_proof_photo);
            }
            $path = $request->file('proof_photo')->store('evidence', 'public');
            $purchase->transaction_proof_photo = $path;
        }

        $purchase->status = 'completed';
        $purchase->is_purchased = true;
        $purchase->save();

        // ============================================================
        // 3. LOGIKA MASUK TOOLS (ASET GENERATOR) - KODE ANDA
        // ============================================================
        
        // A. Tentukan Prefix Kode (Misal: LAP untu Laptop)
        $prefix = 'GEN'; 
        if ($purchase->category && !empty($purchase->category->category_name)) {
            // Ambil 3 huruf pertama kategori, uppercase
            $prefix = strtoupper(substr($purchase->category->category_name, 0, 3));
        }

        // B. Cari Nomor Urut Terakhir di Database
        // Kita ambil angka terakhir SEKALI saja sebelum loop agar lebih cepat
        $lastTool = Tool::where('tool_code', 'like', $prefix . '-%')
                        ->orderByRaw('LENGTH(tool_code) DESC') // Urutkan panjang string dulu
                        ->orderBy('tool_code', 'desc')         // Baru urutkan kodenya
                        ->first();
        
        $nextNumber = 1;
        if ($lastTool) {
            $parts = explode('-', $lastTool->tool_code);
            // Ambil angka paling belakang
            if (count($parts) >= 2) {
                $nextNumber = intval(end($parts)) + 1;
            }
        }

        // C. Looping Sebanyak Quantity (Beli 5 = Buat 5 Baris)
        for ($i = 0; $i < $purchase->quantity; $i++) {
            
            // Format Kode: ABC-001, ABC-002, dst
            $generatedCode = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Create Data Tool
            Tool::create([
                'tool_code'           => $generatedCode,
                'tool_name'           => $purchase->tool_name,
                'brand'               => $request->brand,      // Dari Input User
                'purchase_date'       => $purchase->date,      // Dari Tanggal Beli
                'category_id'         => $purchase->category_id,
                // 'purchase_item_id' => $purchase->id,        // (Opsional: Kalau di tabel tools ada kolom ini, nyalakan)
                'quantity'            => 1,                    // Karena aset, qty per baris selalu 1
                'current_condition'   => 'Baik',               // Default
                'availability_status' => 'available',          // Default
                'description'         => $purchase->specification,
                'image'               => $purchase->transaction_proof_photo, // Opsional: Foto nota jadi foto aset
            ]);

            // Naikkan nomor urut untuk putaran berikutnya
            $nextNumber++;
        }

        return redirect()->back()->with('success', 'Transaksi Selesai! ' . $purchase->quantity . ' item telah masuk ke Inventaris.');
    }
}