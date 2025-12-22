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
        // Kita butuh data Peminjam dan Alat untuk ditampilkan di Select Option (Dropdown)
        $borrowers = Borrower::orderBy('name')->get();
        
        // Hanya ambil alat yang statusnya 'available' (tersedia)
        $tools = Tool::where('availability_status', 'available')->get();

        return view('borrowings.create', compact('borrowers', 'tools'));
    }

    // method store() disini untuk menyimpan data
    public function store(Request $request)
    {
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'planned_return_date' => 'required|date|after_or_equal:today',
            'tool_ids' => 'required|array|min:1', // Wajib pilih minimal 1 alat
        ], [
            'tool_ids.required' => 'Anda belum memilih alat apapun!',
        ]);

        // Gunakan Transaction agar data aman
        try {
            DB::beginTransaction();

            // 2. Buat Data Peminjaman (Header)
            $borrowing = Borrowing::create([
                'borrower_id' => $request->borrower_id,
                'user_id' => Auth::id(), // Petugas yang input (Login saat ini)
                'borrow_date' => now(), // Tanggal pinjam = Detik ini
                'planned_return_date' => $request->planned_return_date,
                'borrowing_status' => 'active', // Status sedang dipinjam
            ]);

            // 3. Proses Setiap Alat yang Dipilih
            foreach ($request->tool_ids as $toolId) {
                $tool = Tool::find($toolId);

                // Catat di tabel detail (borrowing_items)
                BorrowingItem::create([
                    'borrowing_id' => $borrowing->id,
                    'tool_id' => $toolId,
                    'tool_condition_before' => $tool->current_condition, // Catat kondisi saat diambil
                ]);

                // Update status alat jadi "borrowed" (supaya tidak muncul di list lagi)
                $tool->update(['availability_status' => 'borrowed']);
            }

            DB::commit(); // Simpan permanen jika semua lancar

            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dicatat!');

       } catch (\Exception $e) {
            DB::rollBack(); 
            
            // --- UBAH BAGIAN INI SEMENTARA ---
            // Kita paksa tampilkan error di layar putih
            dd($e->getMessage()); 
            
            // Kode lama (dimatikan dulu):
            // return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}