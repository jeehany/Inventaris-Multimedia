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
use App\Http\Controllers\UserController;

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
    Route::get('/tools/trash/export', [ToolController::class, 'exportTrash'])->name('tools.exportTrash');
    Route::get('/tools/trash', [ToolController::class, 'trash'])->name('tools.trash');
    Route::put('/tools/{id}/restore', [ToolController::class, 'restore'])->name('tools.restore');
    
    // 2. Export & Custom
    Route::get('tools/export-pdf', [ToolController::class, 'exportPdf'])->name('tools.exportPdf');
    Route::get('tools/export-excel', [ToolController::class, 'exportExcel'])->name('tools.exportExcel');
    
    // 3. Resource & Kategori
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category}/next-code', [CategoryController::class, 'nextCode'])->name('categories.nextCode');
    Route::resource('tools', ToolController::class);


    // --- Peminjam & Peminjaman ---
    Route::resource('borrowers', BorrowerController::class);
    
    // Custom Routes Peminjaman
    Route::get('/borrowings/export-pdf', [BorrowingController::class, 'exportPdf'])->name('borrowings.exportPdf');
    Route::get('/borrowings/export-excel', [BorrowingController::class, 'exportExcel'])->name('borrowings.exportExcel');
    Route::put('/borrowings/{id}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
    Route::get('/get-tools/{categoryId}', [BorrowingController::class, 'getToolsByCategory'])->name('tools.getByCategory');
    
    Route::resource('borrowings', BorrowingController::class);


    // --- Manajemen Pembelian (UPDATED LOGIC) ---
    Route::resource('vendors', VendorController::class);

    // 1. Halaman List / Tampilan
    // Halaman Approval (Status Pending)
    Route::get('/purchases/requests', [PurchaseController::class, 'indexRequests'])->name('purchases.request');
    
    // Halaman Riwayat (Status Rejected & Completed/Purchased)
    Route::get('/purchases/transaction', [PurchaseController::class, 'indexTransaction'])->name('purchases.transaction');
    Route::get('/purchases/history/export', [PurchaseController::class, 'exportHistoryExcel'])->name('purchases.history.export'); // <--- BARU
    Route::get('/purchases/history', [PurchaseController::class, 'indexHistory'])->name('purchases.history');
    Route::put('/purchases/{id}/process', [PurchaseController::class, 'process'])->name('purchases.process');

    // 2. Action Routes (Tombol Aksi)
    // List Pengajuan (Pending, Approved, Rejected)
    Route::get('/purchases/request', [PurchaseController::class, 'requestList'])->name('purchases.request');
    Route::get('/purchases/request/export', [PurchaseController::class, 'exportRequestExcel'])->name('purchases.request.export'); // <--- BARU
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    // Approve & Reject (Kepala)
    Route::patch('/purchases/{id}/approve', [PurchaseController::class, 'approve'])->name('purchases.approve');
    Route::patch('/purchases/{id}/reject', [PurchaseController::class, 'reject'])->name('purchases.reject');
    // Upload Bukti / Eksekusi Belanja (Admin)
    Route::post('/purchases/{id}/evidence', [PurchaseController::class, 'storePurchaseEvidence'])->name('purchases.evidence');
    
    // 3. Resource Purchases (CRUD Dasar)
    // Menggunakan except 'index' karena kita sudah buat custom index di atas (requests, todos, history)
    Route::resource('purchases', PurchaseController::class)->except(['index', 'update', 'edit', 'create']);


    // --- Maintenance Routes ---
    Route::get('maintenances/export', [MaintenanceController::class, 'exportExcel'])->name('maintenances.export');
    Route::resource('maintenances', MaintenanceController::class);
    Route::resource('maintenance-types', MaintenanceTypeController::class);

    // ROUTE USER MANAGEMENT
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';