<?php

namespace App\Http\Controllers;

use App\Models\Tool; // Panggil Model Tool
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

        // 2. Kirim datanya ke tampilan (view)
        return view('tools.index', compact('tools'));
    }

    // ... fungsi create, store, dll biarkan kosong dulu

    public function create()
    {
        return view('tools.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data (Wajib diisi)
        $request->validate([
            'tool_code' => 'required',
            'tool_name' => 'required',
        ]);

        // 2. Simpan ke database
        // Kita isi manual dulu kolom lain untuk tes awal
        $data = $request->all();
        $data['current_condition'] = 'Baik'; // Default kondisi
        $data['availability_status'] = 'Tersedia'; // Default status
        
        Tool::create($data);

        // 3. Kembali ke halaman tabel
        return redirect()->route('tools.index');
    }

}