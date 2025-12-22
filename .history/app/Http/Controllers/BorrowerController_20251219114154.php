<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function index()
    {
        $borrowers = Borrower::latest()->get();
        return view('borrowers.index', compact('borrowers'));
    }

    // Nanti kita tambah create, store, edit, update, destroy di sini
}