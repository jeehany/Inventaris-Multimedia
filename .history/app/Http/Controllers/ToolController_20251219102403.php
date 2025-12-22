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

}