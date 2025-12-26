<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // --- Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Manajemen Alat (Tools) ---
    // 1. Trash & Restore (WAJIB DI ATAS Resource)
    Route::get('/tools/trash', [ToolController::class, 'trash'])->name('tools.trash');
    Route::put('/tools/{id}/restore', [ToolController::class, 'restore'])->name('tools.restore');
    
    // 2. Export & Custom
    Route::get('tools/export-pdf', [ToolController::class, 'exportPdf'])->name('tools.exportPdf');
    
    // 3. Resource & Kategori
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category}/next-code', [CategoryController::class, 'nextCode'])->name('categories.nextCode');
    Route::resource('tools', ToolController::class);


    // --- Peminjam & Peminjaman ---
    Route::resource('borrowers', BorrowerController::class);
    
    // Custom Routes Peminjaman
    Route::get('/borrowings/export-pdf', [BorrowingController::class, 'exportPdf'])->name('borrowings.exportPdf');
    Route::put('/borrowings/{id}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
    Route::get('/get-tools/{categoryId}', [BorrowingController::class, 'getToolsByCategory'])->name('tools.getByCategory');
    
    Route::resource('borrowings', BorrowingController::class);


    // --- Manajemen Pembelian (UPDATED) ---
    Route::resource('vendors', VendorController::class);

    // 1. Route Khusus Pembelian (WAJIB DI ATAS Resource Purchases)
    // Agar tidak dianggap sebagai ID (misal: /purchases/approved tidak dianggap /purchases/{id})
    Route::get('/purchases/report', [PurchaseController::class, 'report'])->name('purchases.report');
    Route::get('/purchases/approved', [PurchaseController::class, 'approvedList'])->name('purchases.approved'); // Untuk Menu "Pembelian Barang"
    Route::get('/purchases/history', [PurchaseController::class, 'history'])->name('purchases.history'); // Untuk Menu "Riwayat"

    // 2. Action Approval & Upload
    Route::post('/purchases/{purchase}/approve', [PurchaseController::class, 'approve'])->name('purchases.approve');
    Route::post('/purchases/{purchase}/reject', [PurchaseController::class, 'reject'])->name('purchases.reject');
    Route::post('/purchases/{id}/upload-proof', [PurchaseController::class, 'uploadProof'])->name('purchases.uploadProof'); // Logic upload bukti

    // 3. Resource Purchases (CRUD Utama)
    Route::resource('purchases', PurchaseController::class);


    // --- Maintenance Routes ---
    Route::resource('maintenances', MaintenanceController::class);
    Route::resource('maintenance-types', MaintenanceTypeController::class);
});

require __DIR__.'/auth.php';