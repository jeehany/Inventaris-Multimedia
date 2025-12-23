<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel purchases
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            
            // Relasi ke kategori (PENTING: sesuaikan nama tabel kategori kamu 'tool_categories')
            $table->foreignId('category_id')->constrained('tool_categories'); 
            
            // Kolom Data Barang
            $table->string('tool_name');  // <-- Ini yang tadi error (hilang)
            $table->string('specification')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            
            // Tidak perlu timestamps() untuk tabel pivot/item
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};