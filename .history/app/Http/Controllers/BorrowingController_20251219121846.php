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

    // Nanti kita isi method store() disini untuk menyimpan data
}