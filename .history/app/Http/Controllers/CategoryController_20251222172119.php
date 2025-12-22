<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Tool;

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

    /**
     * Return next tool code for a given category (prefix + incremental number)
     */
    public function nextCode($id)
    {
        $category = Category::findOrFail($id);
        $prefix = $category->code;
        if (!$prefix) {
            return response()->json(['next' => null]);
        }

        // Find last tool for this category by tool_code pattern
        $last = Tool::where('category_id', $id)
                    ->where('tool_code', 'like', strtoupper($prefix).'%')
                    ->orderBy('id', 'desc')
                    ->first();

        $nextNumber = 1;
        if ($last && preg_match('/(\d+)$/', $last->tool_code, $m)) {
            $nextNumber = intval($m[1]) + 1;
        }

        $next = strtoupper($prefix) . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        return response()->json(['next' => $next]);
    }
}