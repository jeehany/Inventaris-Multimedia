<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 1. Halaman Daftar Kategori (Tabel)
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // 2. Halaman Form Tambah Kategori (Mirip Tool Create)
    public function create()
    {
        return view('categories.create');
    }

    // 3. Proses Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create hanya akan mengambil data yang ada di $fillable (name), _token otomatis dibuang
        Category::create($request->all());

        return redirect()->route('categories.index');
    }

    // 4. Hapus Kategori
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}