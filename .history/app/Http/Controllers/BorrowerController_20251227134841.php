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
        // 1. Cek Validasi Manual (Agar error muncul di layar putih)
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:borrowers,code', // <-- Perhatikan ini
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            // INI AKAN MENAMPILKAN ERROR DI LAYAR
            dd([
                'Status' => 'Validasi Gagal',
                'Pesan Error' => $validator->errors()->all(),
                'Data yang Anda Input' => $request->all()
            ]);
        }

        // 2. Coba Simpan ke Database
        try {
            $data = $request->only(['code', 'name', 'phone']);
            
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('borrowers', 'public');
                $data['photo'] = $path;
            }

            \App\Models\Borrower::create($data);

        } catch (\Exception $e) {
            // INI AKAN MUNCUL JIKA DATABASE BERMASALAH (Misal ID tidak auto increment)
            dd([
                'Status' => 'Error Database',
                'Pesan' => $e->getMessage()
            ]);
        }

        return redirect()->route('borrowers.index')->with('success', 'Data berhasil ditambahkan.');
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