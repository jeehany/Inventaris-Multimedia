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

    

}