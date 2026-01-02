<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tool;      // Sesuaikan nama Model Barang/Alat Anda
use App\Models\Borrowing; // Sesuaikan nama Model Peminjaman Anda

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isHead()) {
            // === DATA UNTUK KEPALA (Monitoring & Approval) ===
            $data = [
                // 1. ACTION NEEDED: Pengajuan Pembelian Menunggu
                'pending_purchases_count' => \App\Models\Purchase::where('status', 'pending')->count(),

                // 2. Monitoring: Peminjaman Bulan Ini
                'monthly_borrowings' => Borrowing::whereMonth('borrow_date', now()->month)
                                        ->whereYear('borrow_date', now()->year)
                                        ->count(),
                
                // 3. Monitoring: Barang Sedang Dipinjam
                'active_borrowings'  => Borrowing::where('borrowing_status', 'active')->count(),

                // 4. Monitoring: Telat Kembali
                'overdue_items'      => Borrowing::where('borrowing_status', 'active')
                                        ->where('planned_return_date', '<', now())
                                        ->count(),
                
                // 5. Tabel Utama: Daftar Pengajuan Pending (Prioritas Utama Kepala)
                'recent_activities'  => \App\Models\Purchase::with(['user', 'vendor'])
                                        ->where('status', 'pending')
                                        ->latest()
                                        ->take(5)
                                        ->get(),

                // 6. Tabel Sekunder: Peminjaman Terakhir (Biar tetap ada info operasional)
                'recent_borrowings'  => Borrowing::with('borrower', 'items.tool')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            ];
        } else {
            // === DATA UNTUK ADMIN (Operasional) ===
            $data = [
                'total_users'       => User::count(),
                'total_tools'       => Tool::count(), // Pastikan model Tool ada
                'active_borrowings' => Borrowing::where('borrowing_status', 'active')->count(),
                'returned_today'    => Borrowing::whereDate('actual_return_date', today())->count(),
                'recent_activities' => Borrowing::with('borrower', 'items.tool')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            ];
        }

        return view('dashboard', compact('data'));
    }
}