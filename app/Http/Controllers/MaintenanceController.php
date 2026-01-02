<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Tool;
use App\Models\MaintenanceType; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua tipe untuk dropdown filter
        $types = MaintenanceType::all();

        // Query Dasar dengan Eager Loading
        $query = Maintenance::with(['tool', 'user', 'type']);

        // 1. Logic Pencarian (Berdasarkan Nama Alat atau Catatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('note', 'like', "%{$search}%")
                  ->orWhereHas('tool', function (Builder $query) use ($search) {
                      $query->where('tool_name', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Logic Filter Status (In Progress / Completed)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Logic Filter Tipe Maintenance
        if ($request->filled('type_id')) {
            $query->where('maintenance_type_id', $request->type_id);
        }

        // Urutkan dari yang terbaru & Pagination
        $maintenances = $query->latest()->paginate(5)->withQueryString();

        return view('maintenances.index', compact('maintenances', 'types'));
    }

    public function create()
    {
        // Block kepala/head from creating maintenance records
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('maintenances.index')->with('error', 'Akses ditolak. Anda tidak dapat mencatat perbaikan.');
        }
        // Mengambil alat yang statusnya TIDAK maintenance
        // Sesuai migration tools: nama kolom 'availability_status'
       $tools = Tool::where('availability_status', 'available')->get();
        
        $types = MaintenanceType::all(); 

        return view('maintenances.create', compact('tools', 'types'));
    }

    public function store(Request $request)
    {
        // Block kepala/head from storing maintenance
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('maintenances.index')->with('error', 'Akses ditolak. Anda tidak dapat mencatat perbaikan.');
        }
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'maintenance_type_id' => 'required|exists:maintenance_types,id',
            'start_date' => 'required|date',
            'note' => 'required|string',
        ]);

        // Cek lagi apakah alat statusnya 'available' sebelum disimpan.
        $tool = Tool::find($request->tool_id);
        
        if ($tool->availability_status !== 'available') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal! Alat ini sedang dipinjam atau sedang dalam perbaikan lain.');
        }

        // Simpan Data
        Maintenance::create([
            'tool_id' => $request->tool_id,
            'maintenance_type_id' => $request->maintenance_type_id,
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'note' => $request->note,
            'status' => 'in_progress',
        ]);

        // Update Status Alat menjadi 'maintenance'
        $tool = Tool::find($request->tool_id);
        $tool->update(['availability_status' => 'maintenance']);

        return redirect()->route('maintenances.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(Maintenance $maintenance)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('maintenances.index')->with('error', 'Akses ditolak.');
        }

        $types = MaintenanceType::all(); 
        return view('maintenances.edit', compact('maintenance', 'types'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        // Cek tombol mana yang diklik berdasarkan value="action"
        $action = $request->input('action');

        // =========================================================
        // SKENARIO 1: KLIK TOMBOL "SELESAI & KEMBALI"
        // =========================================================
        if ($action == 'complete') {
            $request->validate([
                'end_date' => 'required|date|after_or_equal:start_date',
                'cost' => 'required|numeric|min:0',
                // Validasi data info juga, biar gak hilang kalau diedit barengan
                'note' => 'nullable|string',
                'action_taken' => 'nullable|string',
            ]);

            $maintenance->update([
                // Update Data Info (Kiri) agar tersimpan juga
                'note' => $request->note,
                'action_taken' => $request->action_taken,
                'maintenance_type_id' => $request->maintenance_type_id,
                'start_date' => $request->start_date,
                
                // Update Data Selesai (Kanan)
                'end_date' => $request->end_date,
                'cost' => $request->cost,
                'status' => 'completed',
            ]);

            // Kembalikan alat jadi Available
            if ($maintenance->tool) {
                $maintenance->tool->update([
                    'availability_status' => 'available',
                    'current_condition'   => 'Baik'
                ]);
            }

            return redirect()->route('maintenances.index')->with('success', 'Perbaikan selesai & Data tersimpan.');
        }

        // =========================================================
        // SKENARIO 2: KLIK TOMBOL "SIMPAN INFO" (Update Biasa)
        // =========================================================
        // Default action kalau bukan complete
        
        $request->validate([
            'note' => 'required|string',
            'start_date' => 'required|date',
            'maintenance_type_id' => 'required|exists:maintenance_types,id',
            'action_taken' => 'nullable|string',
        ]);
        
        $maintenance->update([
            'start_date' => $request->start_date,
            'note' => $request->note,
            'maintenance_type_id' => $request->maintenance_type_id,
            'action_taken' => $request->action_taken,
            'status' => ($maintenance->status == 'pending') ? 'in_progress' : $maintenance->status
        ]);

        return redirect()->back()->with('success', 'Informasi perbaikan diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        // Block kepala/head from deleting maintenance
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('maintenances.index')->with('error', 'Akses ditolak. Anda tidak dapat menghapus data perbaikan.');
        }
        // Jika dihapus saat sedang perbaikan, kembalikan status alat
        if ($maintenance->status == 'in_progress' && $maintenance->tool) {
            $maintenance->tool->update(['availability_status' => 'available']);
        }
        
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('success', 'Data dihapus.');
    }

    public function exportExcel(Request $request)
    {
        // Query Dasar dengan Eager Loading
        $query = Maintenance::with(['tool', 'user', 'type']);

        // 1. Logic Pencarian (Berdasarkan Nama Alat atau Catatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('note', 'like', "%{$search}%")
                  ->orWhereHas('tool', function (Builder $query) use ($search) {
                      $query->where('tool_name', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Logic Filter Status (In Progress / Completed)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Logic Filter Tipe Maintenance
        if ($request->filled('type_id')) {
            $query->where('maintenance_type_id', $request->type_id);
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MaintenanceExport($query), 'laporan-perawatan-'.now()->format('Y-m-d').'.xlsx');
    }
}