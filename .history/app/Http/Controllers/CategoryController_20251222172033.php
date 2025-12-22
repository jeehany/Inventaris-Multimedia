<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:10|unique:tool_categories,code',
        ]);

        Category::create($request->only('category_name', 'description', 'code'));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:10|unique:tool_categories,code,'.$id,
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->only('category_name', 'description', 'code'));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}