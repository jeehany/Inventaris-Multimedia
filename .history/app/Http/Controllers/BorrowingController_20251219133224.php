<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\Borrower;
use App\Models\BorrowingItem; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB: Untuk Database Transaction
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // Menampilkan seluruh daftar riwayat peminjaman
    public function index()
    {
        // Kita ambil data peminjaman, urutkan dari yang terbaru
        // 'with' digunakan agar kita bisa mengambil nama peminjam & user tanpa loading lama
        $borrowings = Borrowing::with(['borrower', 'user'])->latest()->get();
        
        return view('borrowings.index', compact('borrowings'));
    }

    // Menampilkan formulir tambah peminjaman
    public function create()
    {
        $borrowers = \App\Models\Borrower::all();
        // Kita kirim data Kategori juga sekarang
        $categories = \App\Models\Category::all(); 
        
        return view('borrowings.create', compact('borrowers', 'categories'));
    }

    // method store() disini untuk menyimpan data
    public function store(Request $request)
    {
        // 1. Validasi input (Tambahkan 'notes')
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'tool_ids' => 'required|array',
            'tool_ids.*' => 'exists:tools,id',
            'borrow_date' => 'required|date',
            'planned_return_date' => 'required|date|after_or_equal:borrow_date',
            'notes' => 'nullable|string|max:255', // <--- TAMBAHKAN INI
        ]);

        // 2. Simpan ke Database
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'borrower_id' => $request->borrower_id,
            'borrow_date' => $request->borrow_date,
            'planned_return_date' => $request->planned_return_date,
            'borrowing_status' => 'active',
            'notes' => $request->notes, // <--- JANGAN LUPA TAMBAHKAN INI
        ]);

        // Simpan relasi alat (pivot table)
        // (Bagian attach tools tetap sama seperti sebelumnya)
        foreach ($request->tool_ids as $toolId) {
            $borrowing->items()->create([
                'tool_id' => $toolId,
            ]);
            
            // Update stok alat jadi berkurang (Opsional/Sesuai logika stok Anda)
            // \App\Models\Tool::find($toolId)->decrement('stock');
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    // Fungsi untuk memproses pengembalian
    public function returnItem($id)
    {
        // 1. Cari data peminjamannya
        $borrowing = Borrowing::with('items.tool')->findOrFail($id);

        // 2. Update status peminjaman
        $borrowing->update([
            'borrowing_status' => 'returned', // Status jadi Kembali
            'actual_return_date' => now(),    // Tanggal kembali = Detik ini
        ]);

        // 3. Kembalikan Status Alat menjadi 'Available'
        foreach ($borrowing->items as $item) {
            $tool = $item->tool;
            $tool->update(['availability_status' => 'available']);
        }

        // 4. Balik ke halaman tadi dengan pesan sukses
        return redirect()->route('borrowings.index')->with('success', 'Barang berhasil dikembalikan! Stok alat sudah bertambah.');
    }

    // --- Menampilkan Halaman Edit ---
    public function edit($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowers = \App\Models\Borrower::all(); // Ambil data peminjam
        
        // Kita tidak mengizinkan edit alat di sini agar stok tidak rusak, 
        // jadi cuma edit tanggal/catatan saja.
        return view('borrowings.edit', compact('borrowing', 'borrowers'));
    }

    // --- Menyimpan Perubahan Edit ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'planned_return_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $borrowing = Borrowing::findOrFail($id);
        
        $borrowing->update([
            'planned_return_date' => $request->planned_return_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    // --- Hapus Data (Opsional) ---
    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();
        
        return redirect()->route('borrowings.index')->with('success', 'Riwayat berhasil dihapus.');
    }

    public function getToolsByCategory($categoryId)
    {
        // Ambil alat berdasarkan kategori DAN statusnya Available
        $tools = \App\Models\Tool::where('category_id', $categoryId)
                    ->where('availability_status', 'available') // Hanya yang tersedia
                    ->get();
                    
        return response()->json($tools);
    }
}