<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrower::query();

        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%");
        }

        $borrowers = $query->latest()->paginate(10)->withQueryString();
        return view('borrowers.index', compact('borrowers'));
    }

    public function create() { return view('borrowers.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:borrowers,code', // NIS atau NIP harus unik
            'contact' => 'nullable|string'
        ]);

        Borrower::create($request->all());
        return redirect()->route('borrowers.index')->with('success', 'Data peminjam berhasil ditambahkan.');
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
        ]);

        $borrower = Borrower::findOrFail($id);
        $borrower->update($request->all());

        return redirect()->route('borrowers.index')->with('success', 'Data peminjam diperbarui.');
    }

    public function destroy($id)
    {
        Borrower::findOrFail($id)->delete();
        return redirect()->route('borrowers.index')->with('success', 'Data peminjam dihapus.');
    }
}