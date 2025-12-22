<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Fitur Pencarian
        if ($request->has('search') && $request->search != null) {
            $query->where('category_name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:50|unique:categories,category_name'
        ]);

        Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:50|unique:categories,category_name,'.$id
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Opsional: Cek apakah kategori masih dipakai alat
        if($category->tools()->count() > 0){
            return redirect()->back()->with('error', 'Gagal hapus! Kategori ini masih digunakan oleh alat.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}