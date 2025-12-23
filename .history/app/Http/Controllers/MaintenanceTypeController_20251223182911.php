<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceType;
use Illuminate\Http\Request;

class MaintenanceTypeController extends Controller
{
    public function index()
{
    $maintenanceTypes = \App\Models\MaintenanceType::all();
    return view('maintenance_types.index', compact('maintenanceTypes'));
}

    public function create()
    {
        return view('maintenance_types.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        MaintenanceType::create($request->all());
        return redirect()->route('maintenance-types.index')->with('success', 'Jenis maintenance berhasil dibuat.');
    }

    // public function edit($id)
    // {
    //     // Kita cari datanya, lalu simpan dengan nama $maintenance
    //     $maintenance = \App\Models\MaintenanceType::findOrFail($id);

    //     // Kirim ke view
    //     return view('maintenance_types.edit', compact('maintenance'));
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // Pastikan ini ada
        ]);

        $type = \App\Models\MaintenanceType::findOrFail($id);
        
        $type->update([
            'name' => $request->name,
            'description' => $request->description, // Simpan deskripsi
        ]);

        // Redirect kembali ke halaman Index (supaya popup tertutup dan data ter-refresh)
        return redirect()->route('maintenance-types.index')->with('success', 'Berhasil diupdate');
    }

    public function destroy(MaintenanceType $maintenanceType)
    {
        $maintenanceType->delete();
        return redirect()->route('maintenance-types.index')->with('success', 'Data dihapus.');
    }
}