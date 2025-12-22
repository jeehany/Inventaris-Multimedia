<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BorrowerController extends Controller
{
    public function index()
    {
        $borrowers = Borrower::latest()->get();
        return view('borrowers.index', compact('borrowers'));
    }

    public function create()
    {
        return view('borrowers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:borrowers,code', // NIS/NIP harus unik
            'name' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $data = $request->all();

        // Proses Upload Foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('borrowers_photos', 'public');
            $data['photo'] = $path;
        }

        Borrower::create($data);

        return redirect()->route('borrowers.index')->with('success', 'Peminjam berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:borrowers,code,'.$id, // Unik kecuali punya sendiri
            'name' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $borrower = Borrower::findOrFail($id);
        $data = $request->all();

        // Cek jika ada upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($borrower->photo) {
                Storage::disk('public')->delete($borrower->photo);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('borrowers_photos', 'public');
            $data['photo'] = $path;
        }

        $borrower->update($data);

        return redirect()->route('borrowers.index')->with('success', 'Data peminjam diperbarui!');
    }

    public function destroy($id)
    {
        $borrower = Borrower::findOrFail($id);
        
        // Hapus file foto dari penyimpanan sebelum hapus data
        if ($borrower->photo) {
            Storage::disk('public')->delete($borrower->photo);
        }

        $borrower->delete();

        return redirect()->route('borrowers.index')->with('success', 'Peminjam dihapus!');
    }
}