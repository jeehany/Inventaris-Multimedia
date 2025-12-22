<?php

namespace App\Http\Controllers;

use App\Models\Tool; // Panggil Model Tool
use App\Models\Category;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil semua data alat dari database
        $tools = Tool::all();

        // Ambil semua data kategori (untuk ditampilkan di bagian atas halaman)
        $categories = \App\Models\Category::all();

        // Kirim keduanya ke view
        return view('tools.index', compact('tools', 'categories'));
    }

    // ... fungsi create, store, dll biarkan kosong dulu

    public function create()
    {
        // 1. Ambil semua data kategori dari database
        $categories = \App\Models\Category::all();

        // 2. Kirim variabel $categories ke view
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data (Wajib diisi)
        $request->validate([
            'tool_code' => 'required',
            'tool_name' => 'required',
            'current_condition' => 'required',
            'availability_status' => 'required', // Pastikan status dipilih
        ]);

        // 2. Simpan ke database (Langsung semua data dari form)
        Tool::create($request->all());

        // 3. Kembali ke halaman tabel
        return redirect()->route('tools.index');
    }

    // 1. Menampilkan Halaman Edit
    public function edit($id)
    {
        // Cari alat berdasarkan ID
        $tool = \App\Models\Tool::findOrFail($id);
        
        // Ambil semua kategori (untuk isi dropdown)
        $categories = \App\Models\Category::all();

        return view('tools.edit', compact('tool', 'categories'));
    }

    // 2. Proses Simpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'tool_code' => 'required',
            'tool_name' => 'required',
            'category_id' => 'required', // Pastikan kategori dipilih
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $tool = \App\Models\Tool::findOrFail($id);
        
        // Update semua data yang dikirim formulir
        $tool->update($request->all());

        return redirect()->route('tools.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    // 3. Proses Hapus (Destroy)
    public function destroy($id)
    {
        $tool = \App\Models\Tool::findOrFail($id);
        $tool->delete();

        return redirect()->route('tools.index')->with('success', 'Data alat berhasil dihapus!');
    }

}