<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\MaintenanceType;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with(['tool', 'user', 'type'])->latest()->paginate(10);
        return view('maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        // PERBAIKAN: Gunakan 'availability_status' sesuai database
        // Ambil alat yang statusnya TIDAK SEDANG DIPINJAM (borrowed)
        $tools = Tool::where('availability_status', '!=', 'borrowed')->get();
        
        $types = MaintenanceType::all();
        
        return view('maintenances.create', compact('tools', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'maintenance_type_id' => 'required|exists:maintenance_types,id',
            'start_date' => 'required|date',
            'note' => 'required|string',
        ]);

        // 1. Buat Data Maintenance
        Maintenance::create([
            'tool_id' => $request->tool_id,
            'maintenance_type_id' => $request->maintenance_type_id,
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'note' => $request->note,
            'status' => 'in_progress', // Status perbaikan (bukan status alat)
        ]);

        // 2. UPDATE Status Alat Jadi 'maintenance'
        // PERBAIKAN: Gunakan 'availability_status'
        $tool = Tool::find($request->tool_id);
        $tool->update(['availability_status' => 'maintenance']);

        return redirect()->route('maintenances.index')->with('success', 'Alat berhasil didaftarkan ke perbaikan.');
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

            // 3. UPDATE Status Alat Kembali Jadi 'available'
            // PERBAIKAN: Gunakan 'availability_status'
            $maintenance->tool->update(['availability_status' => 'available']);

            return redirect()->route('maintenances.index')->with('success', 'Perbaikan selesai! Alat kembali tersedia.');
        }

        $maintenance->update($request->only('note', 'start_date'));
        return redirect()->route('maintenances.index')->with('success', 'Data perbaikan diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        // Jika hapus data sedang berjalan, kembalikan status alat jadi available
        if ($maintenance->status == 'in_progress') {
            // PERBAIKAN: Gunakan 'availability_status'
            $maintenance->tool->update(['availability_status' => 'available']);
        }
        
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('success', 'Data dihapus.');
    }
}