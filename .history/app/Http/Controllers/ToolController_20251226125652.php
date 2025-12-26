<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Imp

class ToolController extends Controller
{
    /**
     * Helper: Logika Filter (Dipakai Index & PDF)
     */
    private function getFilteredQuery(Request $request)
    {
        $query = Tool::with('category');

        // 1. Search Nama Alat
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('tool_name', 'like', '%' . $request->search . '%')
                  ->orWhere('tool_code', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // 3. Filter Kondisi
        $cond = $request->input('current_condition', $request->input('condition'));
        if ($cond) {
            $query->where('current_condition', $cond);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        
        $tools = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('tools.index', compact('tools', 'categories'));
    }

    // --- FUNGSI EXPORT PDF ---
    public function exportPdf(Request $request)
    {
        // 1. Ambil data pakai filter yang sama, tapi get() semua (tanpa paginate)
        $query = $this->getFilteredQuery($request);
        $tools = $query->latest()->get();

        // 2. Load View PDF
        $pdf = Pdf::loadView('tools.pdf', compact('tools'));
        
        // 3. Download
        return $pdf->download('laporan-inventaris-' . now()->format('Y-m-d') . '.pdf');
    }

    public function create() {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }

        $categories = Category::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }
        $request->validate([
            'tool_code' => 'required|string|unique:tools,tool_code',
            'tool_name' => 'required|string',
            'category_id' => 'required|exists:tool_categories,id',
            'current_condition' => 'required|string',
            'availability_status' => 'nullable|in:available,borrowed,maintenance,lost',
        ]);

        $data = $request->only(['tool_code', 'tool_name', 'category_id', 'current_condition', 'availability_status']);
        $data['availability_status'] = $data['availability_status'] ?? 'available';

        Tool::create($data);
        return redirect()->route('tools.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit($id) {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }
        $tool = Tool::findOrFail($id);
        $categories = Category::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }
        $request->validate([
            'tool_name'   => 'required|string|max:255',
            'category_id' => 'required|exists:tool_categories,id',
            'current_condition' => 'required|string',
        ]);
        
        $tool = Tool::findOrFail($id);
        
        $tool->update([
            'tool_name'           => $request->tool_name,
            'category_id'         => $request->category_id,
            'current_condition'   => $request->current_condition, 
            'availability_status' => $request->availability_status,
        ]);

        return redirect()->route('tools.index')->with('success', 'Data alat diperbarui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }

        $tool = Tool::findOrFail($id);
        $tool->delete();

        return redirect()->route('tools.index')->with('success', 'Alat berhasil dinonaktifkan.');
    }
}