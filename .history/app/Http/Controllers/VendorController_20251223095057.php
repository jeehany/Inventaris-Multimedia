<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Menampilkan daftar vendor
    public function index()
    {
        $vendors = Vendor::latest()->get();
        return view('vendors.index', compact('vendors'));
    }

    // Menampilkan form tambah vendor
    public function create()
    {
        return view('vendors.create');
    }

    // Menyimpan data vendor baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        Vendor::create($request->all());

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    // Update data vendor
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $vendor->update($request->all());

        return redirect()->route('vendors.index')
            ->with('success', 'Data vendor berhasil diperbarui.');
    }

    // Hapus vendor
    public function destroy(Vendor $vendor)
    {
        // Cek dulu apakah vendor ini punya riwayat transaksi
        if($vendor->purchases()->exists()) {
            return back()->with('error', 'Vendor tidak bisa dihapus karena memiliki riwayat pembelian.');
        }

        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor berhasil dihapus.');
    }
}