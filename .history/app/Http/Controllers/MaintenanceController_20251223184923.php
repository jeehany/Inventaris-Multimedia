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
        // Ambil data maintenance terbaru
        $maintenances = Maintenance::with(['tool', 'user'])->latest()->paginate(10);
        return view('maintenances.index', compact('maintenances'));
    }

    // Form Tambah Maintenance
    public function create()
    {
        $tools = Tool::where('status', '!=', 'borrowed')->get();
        // TAMBAHAN: Ambil data tipe
        $types = \App\Models\MaintenanceType::all(); 

        return view('maintenances.create', compact('tools', 'types'));
    }

    // Proses Simpan (Mulai Service)
    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required',
            'maintenance_type_id' => 'required', // Validasi baru
            'start_date' => 'required|date',
            'note' => 'required',
        ]);

        Maintenance::create([
            'tool_id' => $request->tool_id,
            'maintenance_type_id' => $request->maintenance_type_id, // Simpan tipe
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'note' => $request->note,
            'status' => 'in_progress',
        ]);

        // ... update status tool & return ...
        $tool = Tool::find($request->tool_id);
        $tool->update(['status' => 'maintenance']);

        return redirect()->route('maintenances.index')->with('success', 'Maintenance tercatat.');
    }

    // Form Edit / Selesaikan
    public function edit(Maintenance $maintenance)
    {
        return view('maintenances.edit', compact('maintenance'));
    }

    // Proses Update (Selesaikan Service)
    public function update(Request $request, Maintenance $maintenance)
    {
        // Jika tombol "Selesai Perbaikan" diklik
        if ($request->has('complete_maintenance')) {
            $request->validate([
                'end_date' => 'required|date',
                'cost' => 'nullable|numeric',
            ]);

            // 1. Update Data Maintenance
            $maintenance->update([
                'end_date' => $request->end_date,
                'cost' => $request->cost ?? 0,
                'status' => 'completed',
            ]);

            // 2. UPDATE Status Alat Kembali Jadi 'available'
            $maintenance->tool->update(['status' => 'available']);

            return redirect()->route('maintenances.index')->with('success', 'Perbaikan selesai! Alat kembali tersedia.');
        }

        // Update biasa (misal edit catatan)
        $maintenance->update($request->only('note', 'start_date'));
        return redirect()->route('maintenances.index')->with('success', 'Data perbaikan diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        // Hati-hati: Jika hapus data sedang berjalan, kembalikan status alat
        if ($maintenance->status == 'in_progress') {
            $maintenance->tool->update(['status' => 'available']);
        }
        
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('success', 'Data dihapus.');
    }
}