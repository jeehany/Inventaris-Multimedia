<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category; // Pastikan model Category di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF

class ToolController extends Controller
{
    /**
     * Menampilkan daftar alat dengan Filter (Search, Kategori, Status)
     */
    public function index(Request $request)
    {
        // 1. Ambil data kategori untuk dropdown filter
        $categories = Category::all();

        // 2. Panggil logika filter (sama seperti di BorrowingController)
        $query = $this->getFilteredQuery($request);

        // 3. Pagination & Append Query String (supaya filter tidak hilang saat pindah hal)
        $tools = $query->latest()->paginate(10)->withQueryString();

        return view('tools.index', compact('tools', 'categories'));
    }

    /**
     * Export PDF Inventaris Alat
     */
    public function exportPdf(Request $request)
    {
        // 1. Gunakan logika filter yang sama
        $query = $this->getFilteredQuery($request);

        // 2. Ambil semua data (tanpa pagination)
        $tools = $query->get();

        // 3. Load View PDF (Kamu perlu buat file resources/views/tools/pdf.blade.php nanti)
        $pdf = Pdf::loadView('tools.pdf', compact('tools'));
        
        // 4. Download
        return $pdf->download('laporan-inventaris-alat-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * [HELPER] Logika Filter Terpusat
     */
    private function getFilteredQuery(Request $request)
    {
        // Load relasi kategori agar query lebih ringan (Eager Loading)
        $query = Tool::with('category');

        // 1. Logika Search (Nama Alat atau Kode Alat)
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tool_name', 'like', '%'.$search.'%')
                  ->orWhere('tool_code', 'like', '%'.$search.'%');
            });
        }

        // 2. Logika Filter Status Ketersediaan
        if ($request->has('status') && $request->status != null) {
            // value status sesuaikan dengan database enum kamu
            // misal: 'available', 'borrowed', 'maintenance'
            $query->where('availability_status', $request->status);
        }

        // 3. Logika Filter Kategori (Pengganti Periode)
        if ($request->has('category_id') && $request->category_id != null && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        return $query;
    }

    // ... method create, store, edit, update, destroy tetap sama ...
    
    public function create()
    {
        $categories = Category::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi dan simpan... (sesuaikan dengan kode lamamu)
        // Contoh singkat:
        $validated = $request->validate([
            'tool_name' => 'required',
            'tool_code' => 'required|unique:tools',
            'category_id' => 'required',
            // ...
        ]);
        
        Tool::create($request->all()); // Sesuaikan field
        return redirect()->route('tools.index')->with('success', 'Alat berhasil ditambahkan');
    }
    
    // Pastikan method lain (edit, update, destroy) tetap ada
}