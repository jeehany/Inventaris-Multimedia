<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Borrowing;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    /**
     * Tampilkan Halaman Monitoring Status Aset & Jadwal Maintenance
     */
    public function index(Request $request)
    {
        // 1. Statistik Ringkasan
        $stats = [
            'total_tools' => Tool::count(),
            'available' => Tool::where('availability_status', 'available')->count(),
            'borrowed' => Tool::where('availability_status', 'borrowed')->count(),
            'maintenance' => Tool::where('availability_status', 'maintenance')->count(),
            'disposed' => Tool::where('availability_status', 'disposed')->count(),
        ];

        // 2. Daftar Aset (Bisa di-filter berdasarkan status)
        $query = Tool::with(['category']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('availability_status', $request->status);
        }
        
        // Ambil data asset dengan pagination
        $tools = $query->orderBy('tool_name', 'asc')->paginate(15)->appends($request->all());

        // Untuk setiap tool, kita mau cari tahu detail lokasinya secara realtime
        // Jika dipinjam, cari data peminjamnya. Jika maintenance, cari data maintenance-nya.
        $toolDetails = [];
        foreach ($tools as $tool) {
            $locationInfo = '-';
            $personInCharge = '-';
            $statusBadgeClass = 'bg-slate-100 text-slate-800';
            $statusLabel = 'Unknown';

            if ($tool->availability_status == 'available') {
                $statusBadgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                $statusLabel = 'Tersedia di Gudang';
                $locationInfo = 'Rak Gudang';
                
            } elseif ($tool->availability_status == 'borrowed') {
                $statusBadgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
                $statusLabel = 'Sedang Dipinjam';
                
                // Cari transaksi peminjaman aktif
                $activeBorrowing = DB::table('borrowing_items')
                    ->join('borrowings', 'borrowing_items.borrowing_id', '=', 'borrowings.id')
                    ->join('borrowers', 'borrowings.borrower_id', '=', 'borrowers.id')
                    ->where('borrowing_items.tool_id', $tool->id)
                    ->where('borrowings.borrowing_status', 'active')
                    ->select('borrowings.borrowing_code', 'borrowers.name as borrower_name')
                    ->first();
                    
                if ($activeBorrowing) {
                    $locationInfo = 'Diluar (Trans: ' . $activeBorrowing->borrowing_code . ')';
                    $personInCharge = $activeBorrowing->borrower_name;
                }

            } elseif ($tool->availability_status == 'maintenance') {
                $statusBadgeClass = 'bg-amber-100 text-amber-800 border-amber-200';
                $statusLabel = 'Dalam Perbaikan';
                
                // Cari transaksi perbaikan aktif
                $activeMaintenance = Maintenance::with('type')
                    ->where('tool_id', $tool->id)
                    ->where('status', 'in_progress')
                    ->first();
                    
                if ($activeMaintenance) {
                    $locationInfo = 'Pusat Servis / Teknisi';
                    $personInCharge = 'Teknisi MT (' . ($activeMaintenance->type ? $activeMaintenance->type->name : 'Umum') . ')';
                }

            } elseif ($tool->availability_status == 'disposed') {
                $statusBadgeClass = 'bg-rose-100 text-rose-800 border-rose-200';
                $statusLabel = 'Dihapus/Hilang';
                $locationInfo = 'Tidak Tersedia';
            }

            $toolDetails[$tool->id] = [
                'status_badge' => $statusBadgeClass,
                'status_label' => $statusLabel,
                'location' => $locationInfo,
                'pic' => $personInCharge
            ];
        }

        // 3. Data Jadwal Maintenance (List Alat yg sedang diservis)
        $maintenances = Maintenance::with(['tool', 'type', 'user'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('start_date', 'asc')
            ->get();

        return view('monitoring.index', compact('stats', 'tools', 'toolDetails', 'maintenances'));
    }
}
