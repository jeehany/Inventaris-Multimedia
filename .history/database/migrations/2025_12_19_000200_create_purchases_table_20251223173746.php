<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            
            // Info Barang (Simpel saja)
            $table->string('item_name');     // Nama Barang
            $table->integer('quantity');     // Jumlah
            $table->decimal('estimated_price', 15, 2); // Harga Perkiraan
            $table->text('reason');          // Alasan beli buat apa?
            
            // Status: pending (nunggu), approved (disetujui), rejected (ditolak)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Siapa yang minta? (Admin)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};