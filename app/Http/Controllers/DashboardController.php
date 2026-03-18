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

        if ($user->isKepala()) {
            // === DATA UNTUK KEPALA (Monitoring & Approval) ===
            $data = [
                'pending_purchases_count' => \App\Models\Purchase::where('status', 'pending_head')->count(),
                'monthly_borrowings' => Borrowing::whereMonth('borrow_date', now()->month)
                                        ->whereYear('borrow_date', now()->year)
                                        ->count(),
                'active_borrowings'  => Borrowing::where('borrowing_status', 'active')->count(),
                'overdue_items'      => Borrowing::where('borrowing_status', 'active')
                                        ->where('planned_return_date', '<', now())
                                        ->count(),
                'recent_activities'  => \App\Models\Purchase::with(['user', 'vendor'])
                                        ->where('status', 'pending_head')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
                'recent_borrowings'  => Borrowing::with('borrower', 'items.tool')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            ];
        } elseif ($user->isBendahara()) {
            // === DATA UNTUK BENDAHARA (Laporan & Arsip Pencairan Dana) ===
            $data = [
                'total_purchases' => \App\Models\Purchase::where('status', 'completed')->count(),
                'total_spent_this_month' => \App\Models\Purchase::where('status', 'completed')
                                        ->whereMonth('date', now()->month)
                                        ->sum('total_amount'),
                'approved_purchases_count' => \App\Models\Purchase::where('status', 'approved_head')->count(),
                'monthly_borrowings' => 0, // Bypass variable
                'active_borrowings'  => 0, // Bypass variable
                'overdue_items'      => 0, // Bypass variable
                'recent_activities'  => \App\Models\Purchase::with(['user', 'vendor'])
                                        ->whereIn('status', ['approved_head', 'completed'])
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            ];
        } else {
            // === DATA UNTUK STAFF (Operasional) ===
            $data = [
                'total_users'       => User::count(),
                'total_tools'       => Tool::count(),
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