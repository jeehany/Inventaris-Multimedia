<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // --- Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Master Data (Kategori & Alat) ---
    // Di gambar kamu errornya ada di baris ini (ada tulisan 'Rout'), ini sudah saya hapus.
    Route::resource('categories', CategoryController::class);
    Route::resource('tools', ToolController::class);

    // --- Peminjam & Peminjaman ---
    Route::resource('borrowers', BorrowerController::class);
    Route::resource('borrowings', BorrowingController::class);

    // --- Route Custom (Return & AJAX) ---
    // Saya rapikan pemanggilannya biar tidak panjang dan tidak error
    Route::put('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.returnItem');
    Route::get('/get-tools/{categoryId}', [BorrowingController::class, 'getToolsByCategory'])->name('tools.getByCategory');
});

require __DIR__.'/auth.php';