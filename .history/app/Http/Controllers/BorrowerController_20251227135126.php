<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrower::query();

        // Logika Search yang lebih aman (Grouped)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        // Pagination + Query String (agar search tidak hilang saat pindah halaman)
        $borrowers = $query->latest()->paginate(10)->withQueryString();
        
        return view('borrowers.index', compact('borrowers'));
    }

    public function create() { return view('borrowers.create'); }

    public function store(Request $request)
    {
        // 1. Validasi (HAPUS 'code' dari sini karena user tidak input)
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // 2. Generate Kode Otomatis (Format: PJM-001, PJM-002, dst)
        $latest = \App\Models\Borrower::orderBy('id', 'desc')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        // PJM artinya Peminjam, %03d artinya angka 3 digit (001)
        $generatedCode = 'PJM-' . sprintf("%03d", $nextId); 

        // 3. Siapkan Data
        $data = $request->only(['name', 'phone']);
        $data['code'] = $generatedCode; // Masukkan kode otomatis tadi

        // 4. Upload Foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('borrowers', 'public');
            $data['photo'] = $path;
        }

        // 5. Simpan
        \App\Models\Borrower::create($data);

        return redirect()->route('borrowers.index')->with('success', 'Data peminjam berhasil ditambahkan (Kode: ' . $generatedCode . ').');
    }

    public function edit($id) {
        $borrower = Borrower::findOrFail($id);
        return view('borrowers.edit', compact('borrower'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:borrowers,code,'.$id,
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $borrower = Borrower::findOrFail($id);
        $data = $request->only(['code','name','phone']);
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('borrowers', 'public');
            $data['photo'] = $path;
        }

        $borrower->update($data);

        return redirect()->route('borrowers.index')->with('success', 'Data peminjam diperbarui.');
    }

    public function destroy($id)
    {
        Borrower::findOrFail($id)->delete();
        return redirect()->route('borrowers.index')->with('success', 'Data peminjam dihapus.');
    }
}