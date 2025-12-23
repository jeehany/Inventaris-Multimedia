<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceType;
use Illuminate\Http\Request;

class MaintenanceTypeController extends Controller
{
    public function index()
    {
        $types = MaintenanceType::all();
        return view('maintenance_types.index', compact('types'));
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

    public function update(Request $request, MaintenanceType $maintenanceType)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $maintenanceType->update($request->all());
        return redirect()->route('maintenance-types.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(MaintenanceType $maintenanceType)
    {
        $maintenanceType->delete();
        return redirect()->route('maintenance-types.index')->with('success', 'Data dihapus.');
    }
}