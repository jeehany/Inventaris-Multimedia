<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowingController;

// ... code lain ...

Route::middleware('auth')->group(function () {
    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Resource (Master Data)
    // Hapus tulisan 'Rout' yang tadi ada di ujung baris ini
    Route::resource('categories', CategoryController::class);
    Route::resource('tools', ToolController::class);

    // Route untuk Peminjam
    Route::resource('borrowers', BorrowerController::class);
    Route::resource('borrowings', BorrowingController::class);

    // Route Custom untuk Pengembalian (Return)
    // Saya rapikan path controllernya agar konsisten
    Route::put('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');

    // Route AJAX (Mengambil alat berdasarkan kategori)
    Route::get('/get-tools/{categoryId}', [BorrowingController::class, 'getToolsByCategory'])->name('tools.by.category');
});