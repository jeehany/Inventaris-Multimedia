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
        $maintenances = Maintenance::with(['tool', 'user'])->latest()->paginate(10);
        return view('maintenances.index', compact('maintenances'));
    }

    // Form Tambah Maintenance
    public function create()
    {
        // Ambil alat yang statusnya TIDAK maintenance
        // (Sekarang kode ini tidak akan error lagi karena kolom status sudah dibuat di Langkah 1)
        $tools = Tool::where('status', '!=', 'maintenance')->get();
        
        // Ambil jenis maintenance
        $types = \App\Models\MaintenanceType::all(); 

        return view('maintenances.create', compact('tools', 'types'));
    }

    // Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required',
            'maintenance_type_id' => 'required',
            'start_date' => 'required|date',
            'note' => 'required',
        ]);

        // 1. Simpan Data Maintenance
        // (Sekarang tidak akan error 'Column not found' lagi)
        Maintenance::create([
            'tool_id' => $request->tool_id,
            'maintenance_type_id' => $request->maintenance_type_id,
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'note' => $request->note,
            'status' => 'in_progress',
        ]);

        // 2. Update Status Alat Jadi 'maintenance'
        $tool = Tool::find($request->tool_id);
        if ($tool) {
            $tool->update(['status' => 'maintenance']);
        }

        return redirect()->route('maintenances.index')->with('success', 'Maintenance tercatat & Status alat diperbarui.');
    }

    // Form Edit
    public function edit(Maintenance $maintenance)
    {
        return view('maintenances.edit', compact('maintenance'));
    }

    // Proses Update / Selesai
    public function update(Request $request, Maintenance $maintenance)
    {
        // Jika tombol "Selesai Perbaikan" diklik
        if ($request->has('complete_maintenance')) {
            $request->validate([
                'end_date' => 'required|date',
                'cost' => 'nullable|numeric',
            ]);

            // Update Maintenance jadi selesai
            $maintenance->update([
                'end_date' => $request->end_date,
                'cost' => $request->cost ?? 0,
                'status' => 'completed',
            ]);

            // Kembalikan status alat jadi 'available'
            if ($maintenance->tool) {
                $maintenance->tool->update(['status' => 'available']);
            }

            return redirect()->route('maintenances.index')->with('success', 'Perbaikan selesai! Alat kembali tersedia.');
        }

        // Update biasa
        $maintenance->update($request->only('note', 'start_date'));
        return redirect()->route('maintenances.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        if ($maintenance->status == 'in_progress' && $maintenance->tool) {
            $maintenance->tool->update(['status' => 'available']);
        }
        
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('success', 'Data dihapus.');
    }
}