<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowerController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ... route tools dan categories ...
    Route::resource('categories', CategoryController::class);    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // (Bonus: Hapus Kategori)
    Route::resource('tools', ToolController::class);
    // Route untuk Peminjam
    Route::resource('borrowers', BorrowerController::class);
});

require __DIR__.'/auth.php';
