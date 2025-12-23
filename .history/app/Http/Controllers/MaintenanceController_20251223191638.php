<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    // Tampilkan Daftar Maintenance
    public function index()
    {
        // Hapus 'with' type karena tidak ada relasinya
        $maintenances = Maintenance::with(['tool', 'user'])->latest()->paginate(10);
        return view('maintenances.index', compact('maintenances'));
    }

    // Form Tambah Maintenance
    public function create()
    {
        // PERBAIKAN: Gunakan 'availability_status' sesuai migration
        $tools = Tool::where('availability_status', '!=', 'maintenance')->get();
        
        // HAPUS: $types karena tabel maintenance tidak punya maintenance_type_id
        
        return view('maintenances.create', compact('tools'));
    }

    // Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required',
            // HAPUS: maintenance_type_id validation
            'start_date' => 'required|date',
            'note' => 'required',
        ]);

        // 1. Simpan Data Maintenance
        Maintenance::create([
            'tool_id' => $request->tool_id,
            // HAPUS: maintenance_type_id
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'note' => $request->note,
            'status' => 'in_progress',
        ]);

        // 2. Update Status Alat
        // PERBAIKAN: Gunakan 'availability_status'
        $tool = Tool::find($request->tool_id);
        if ($tool) {
            $tool->update(['availability_status' => 'maintenance']);
        }

        return redirect()->route('maintenances.index')->with('success', 'Maintenance tercatat & Status alat diperbarui.');
    }

    public function edit(Maintenance $maintenance)
    {
        return view('maintenances.edit', compact('maintenance'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        if ($request->has('complete_maintenance')) {
            $request->validate([
                'end_date' => 'required|date',
                'cost' => 'nullable|numeric',
            ]);

            $maintenance->update([
                'end_date' => $request->end_date,
                'cost' => $request->cost ?? 0,
                'status' => 'completed',
            ]);

            // PERBAIKAN: Gunakan 'availability_status'
            if ($maintenance->tool) {
                $maintenance->tool->update(['availability_status' => 'available']);
            }

            return redirect()->route('maintenances.index')->with('success', 'Perbaikan selesai! Alat kembali tersedia.');
        }

        $maintenance->update($request->only('note', 'start_date'));
        return redirect()->route('maintenances.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        // PERBAIKAN: Gunakan 'availability_status'
        if ($maintenance->status == 'in_progress' && $maintenance->tool) {
            $maintenance->tool->update(['availability_status' => 'available']);
        }
        
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('success', 'Data dihapus.');
    }
}