<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolController extends Controller
{
    // ==========================
    // 1. READ DATA (INDEX & PDF)
    // ==========================

    public function index(Request $request)
    {
        $categories = Category::all();

        // Panggil logika filter private di bawah
        $query = $this->getFilteredQuery($request);

        // Pagination & Append Query String
        $tools = $query->latest()->paginate(10)->withQueryString();

        return view('tools.index', compact('tools', 'categories'));
    }

    public function exportPdf(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        
        // Ambil semua data tanpa paginasi untuk PDF
        $tools = $query->get();

        $pdf = Pdf::loadView('tools.pdf', compact('tools'));
        
        return $pdf->download('laporan-inventaris-alat-' . now()->format('Y-m-d') . '.pdf');
    }

    // ==========================
    // 2. SOFT DELETES (TRASH)
    // ==========================

    public function trash()
    {
        // Hanya staff/admin yang boleh lihat tong sampah (opsional)
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
             return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }

        // onlyTrashed() hanya mengambil data yang sudah dihapus
        $tools = Tool::onlyTrashed()->with('category')->paginate(10);
        return view('tools.trash', compact('tools'));
    }

    public function restore($id)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
             return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $tool = Tool::onlyTrashed()->findOrFail($id);
        $tool->restore(); // Mengembalikan data aktif
        return redirect()->back()->with('success', 'Alat dikembalikan ke daftar aktif.');
    }

    // ==========================
    // 3. CRUD (CREATE, UPDATE, DELETE)
    // ==========================

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
            'availability_status' => 'nullable|in:available,borrowed,maintenance,lost,disposed,broken', // Update enum jika perlu
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
        // 1. Cek Role Kepala
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }

        // 2. Eksekusi Hapus (Soft Delete)
        $tool = Tool::findOrFail($id);
        
        
    }

    // ==========================
    // 4. HELPER FUNCTION
    // ==========================

    private function getFilteredQuery(Request $request)
    {
        $query = Tool::with('category');

        // Filter Search
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tool_name', 'like', '%'.$search.'%')
                  ->orWhere('tool_code', 'like', '%'.$search.'%');
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != null) {
            $query->where('availability_status', $request->status);
        }

        // Filter Kategori
        if ($request->has('category_id') && $request->category_id != null && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        return $query;
    }
}