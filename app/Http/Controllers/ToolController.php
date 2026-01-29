<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use App\Models\MaintenanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ToolsExport;

class ToolController extends Controller
{
    // ==========================
    // 1. READ DATA (INDEX & PDF)
    // ==========================

    public function index(Request $request)
    {
        $categories = Category::all();
        $maintenanceTypes = MaintenanceType::all();
        $query = $this->getFilteredQuery($request);
        $tools = $query->latest()->paginate(5)->withQueryString();

        // STATISTICS
        // Kita hitung dari ALAT AKTIF (tidak termasuk soft deleted)
        $totalTools = Tool::count();
        $availableTools = Tool::where('availability_status', 'available')->count();
        $borrowedTools = Tool::where('availability_status', 'borrowed')->count();
        $maintenanceTools = Tool::where('availability_status', 'maintenance')->count();
        $disposedTools = Tool::where('availability_status', 'disposed')->count(); // Optional: kalau mau ditampilkan

        return view('tools.index', compact('tools', 'categories', 'maintenanceTypes', 'totalTools', 'availableTools', 'borrowedTools', 'maintenanceTools', 'disposedTools'));
    }

    public function exportPdf(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $tools = $query->get();
        $pdf = Pdf::loadView('tools.pdf', compact('tools'));
        
        return $pdf->download('laporan-inventaris-alat-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        return Excel::download(new ToolsExport($query), 'laporan-inventaris-alat-' . now()->format('Y-m-d') . '.xlsx');
    }

    // ==========================
    // 2. SOFT DELETES (TRASH)
    // ==========================

    // Menampilkan halaman sampah (soft deleted) dengan Filter & Search
    public function trash(Request $request)
    {
        // 1. Query Dasar: Hanya ambil data yang sudah dihapus (onlyTrashed)
        $query = \App\Models\Tool::onlyTrashed()->with('category');

        // 2. Logika Search (Nama atau Kode)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tool_name', 'like', '%' . $search . '%')
                  ->orWhere('tool_code', 'like', '%' . $search . '%');
            });
        }

        // 3. Logika Filter Kategori
        if ($request->has('category_id') && $request->category_id != '' && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        // 4. Ambil data (Pagination)
        $tools = $query->orderBy('deleted_at', 'desc')->paginate(10);

        // 5. Ambil semua kategori untuk isi dropdown filter
        $categories = \App\Models\Category::all();

        // 6. Return ke view 'tools.trash'
        return view('tools.trash', compact('tools', 'categories'));
    }

    public function exportTrash(Request $request)
    {
         // 1. Query Dasar: Hanya ambil data yang sudah dihapus (onlyTrashed)
         $query = \App\Models\Tool::onlyTrashed()->with('category');

         // 2. Logika Search (Nama atau Kode)
         if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where(function($q) use ($search) {
                 $q->where('tool_name', 'like', '%' . $search . '%')
                   ->orWhere('tool_code', 'like', '%' . $search . '%');
             });
         }
 
         // 3. Logika Filter Kategori
         if ($request->has('category_id') && $request->category_id != '' && $request->category_id != 'all') {
             $query->where('category_id', $request->category_id);
         }

        return Excel::download(new ToolsExport($query), 'laporan-alat-terhapus-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportTrashPdf(Request $request)
    {
         // 1. Query Dasar: Hanya ambil data yang sudah dihapus (onlyTrashed)
         $query = \App\Models\Tool::onlyTrashed()->with('category');

         // 2. Logika Search (Nama atau Kode)
         if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where(function($q) use ($search) {
                 $q->where('tool_name', 'like', '%' . $search . '%')
                   ->orWhere('tool_code', 'like', '%' . $search . '%');
             });
         }
 
         // 3. Logika Filter Kategori
         if ($request->has('category_id') && $request->category_id != '' && $request->category_id != 'all') {
             $query->where('category_id', $request->category_id);
         }

         $tools = $query->get();
         // Menggunakan view yang sama atau khusus trash? Sementara pakai tools.pdf
         // Idealnya tools.trash_pdf tapi user minta restore jadi mungkin pakai yg ada dulu
         $pdf = Pdf::loadView('tools.trash_pdf', compact('tools'));
         
         return $pdf->download('laporan-alat-terhapus-' . now()->format('Y-m-d') . '.pdf');
    }

    public function restore($id)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
             return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $tool = Tool::onlyTrashed()->findOrFail($id);
        
        // Cek apakah kode alat bertabrakan dengan data aktif saat ini
        // Jika kode 'A-001' dihapus, lalu ada 'A-001' baru dibuat, restore akan error/duplicate.
        // Opsional: Tambahkan logika suffix jika duplikat, tapi di sini kita restore standar.
        
        $tool->availability_status = 'available';
        $tool->save();
        $tool->restore();
        
        return redirect()->route('tools.trash')->with('success', 'Alat berhasil dipulihkan ke daftar aktif.');
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
        
        // (Opsional) Kita bisa kirim calon kode berikutnya ke view untuk ditampilkan
        $nextCode = $this->generateNextToolCode(); 

        return view('tools.create', compact('categories', 'nextCode'));
    }

    public function store(Request $request)
    {
        // 1. VALIDASI INPUT (SAYA SESUAIKAN DENGAN FILE BLADE ABANG)
        $request->validate([
            'tool_name'           => 'required|string|max:255',
            'brand'               => 'nullable|string|max:100', // <--- Baru
            'purchase_date'       => 'nullable|date',           // <--- Baru
            'category_id'         => 'required|exists:tool_categories,id',
            'current_condition'   => 'required', 
            'availability_status' => 'required', 
        ]);

        // ==========================================================
        // 2. GENERATOR KODE OTOMATIS
        // ==========================================================
        
        $category = Category::find($request->category_id);

        $prefix = 'TOOL'; 

        // Ambil 3 huruf depan dari category_name
        if ($category && !empty($category->category_name)) {
            $prefix = strtoupper(substr($category->category_name, 0, 3));
        }

        // Cari nomor urut terakhir
        // Cari nomor urut terakhir (termasuk yang soft deleted agar tidak duplikat)
        $lastTool = Tool::withTrashed()
                        ->where('tool_code', 'like', $prefix . '-%')
                        ->orderBy('id', 'desc')
                        ->first();

        $nextNumber = 1;
        
        if ($lastTool) {
            $parts = explode('-', $lastTool->tool_code);
            // Ambil angka paling belakang
            if (count($parts) >= 2) {
                // Hati-hati kalau tool_code bukan format ABC-001. 
                // Kita perlu extra check. Anggap format benar:
                $nextNumber = intval(end($parts)) + 1;
            }
        }

        // Format: PRE-001
        $generatedCode = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // ==========================================================
        
        Tool::create([
            'tool_code'           => $generatedCode, 
            'tool_name'           => $request->tool_name,
            'brand'               => $request->brand,         // <--- Baru
            'purchase_date'       => $request->purchase_date, // <--- Baru
            'category_id'         => $request->category_id,
            'current_condition'   => $request->current_condition,
            'availability_status' => $request->availability_status,
        ]);

        return redirect()->route('tools.index')->with('success', 'Alat baru berhasil ditambahkan.');
    }

    public function show(Tool $tool)
    {
        // Tampilkan Detail
        return view('tools.show', compact('tool'));
    }

    public function edit(Tool $tool)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }

        $categories = Category::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'tool_name'           => 'required|string|max:255',
            'brand'               => 'nullable|string|max:100', // <--- Baru
            'purchase_date'       => 'nullable|date',           // <--- Baru
            'category_id'         => 'required|exists:tool_categories,id',
            'current_condition'   => 'required', 
            'availability_status' => 'required', 
        ]);

        // Kalau update kategori, apakah kode berubah? 
        // Biasanya TIDAK. Kode melekat pada barang. Jadi kita skip logic generate code saat update.

        $tool->update([
            'tool_name'           => $request->tool_name,
            'brand'               => $request->brand,         // <--- Baru
            'purchase_date'       => $request->purchase_date, // <--- Baru
            'category_id'         => $request->category_id,
            'current_condition'   => $request->current_condition,
            'availability_status' => $request->availability_status,
        ]);

        return redirect()->route('tools.index')->with('success', 'Data alat diperbarui.');
    }

    public function destroy(Tool $tool)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['kepala','head'])) {
            return redirect()->route('tools.index')->with('error', 'Akses ditolak.');
        }

        // Soft Delete
        $tool->delete();

        return redirect()->route('tools.index')->with('success', 'Alat dipindahkan ke sampah (Soft Delete).');
    }

    // --- Private Helper ---
    private function getFilteredQuery(Request $request) {
        $query = Tool::with('category');

        // Filter Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tool_name', 'like', '%' . $search . '%')
                  ->orWhere('tool_code', 'like', '%' . $search . '%');
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('availability_status', $request->status);
        }

        // Filter Kategori
        if ($request->has('category_id') && $request->category_id != '' && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        return $query;
    }

    private function generateNextToolCode() {
        // Default Cuma ambil last tool global (opsional, kurang akurat kalau by category)
        // Kita kosongin dulu atau buat logic dummy
        return "AUTO-GEN"; 
    }
}