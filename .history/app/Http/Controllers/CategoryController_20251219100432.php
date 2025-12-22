<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validasi: Nama kategori tidak boleh kosong
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}