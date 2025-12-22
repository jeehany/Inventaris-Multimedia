<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        // Eager load category biar ringan
        $query = Tool::with('category');

        // 1. Search Nama Alat
        if ($request->has('search') && $request->search != null) {
            $query->where('tool_name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori
        if ($request->has('category_id') && $request->category_id != null) {
            $query->where('category_id', $request->category_id);
        }
        
        // 3. Filter Kondisi
        if ($request->has('condition') && $request->condition != null) {
            $query->where('condition', $request->condition);
        }

        $tools = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all(); // Untuk dropdown filter

        return view('tools.index', compact('tools', 'categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'tool_name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|string',
            'amount' => 'required|integer|min:1' // Jika ada stok
        ]);
        
        // Set default status 'available'
        $data = $request->all();
        $data['availability_status'] = 'available';

        Tool::create($data);
        return redirect()->route('tools.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit($id) {
        $tool = Tool::findOrFail($id);
        $categories = Category::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'tool_name' => 'required',
            'category_id' => 'required',
        ]);
        
        Tool::findOrFail($id)->update($request->all());
        return redirect()->route('tools.index')->with('success', 'Data alat diperbarui.');
    }

    public function destroy($id) {
        Tool::findOrFail($id)->delete();
        return redirect()->route('tools.index')->with('success', 'Alat berhasil dihapus.');
    }
}