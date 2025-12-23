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
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            
            // Sesuai tampilan form "Daftar Barang" Anda
            $table->string('item_name'); // Nama Alat
            $table->foreignId('tool_category_id')->nullable()->constrained('tool_categories'); // Kategori
            $table->string('specification')->nullable(); // Spesifikasi
            $table->integer('quantity'); // Qty
            $table->decimal('price', 15, 2); // Harga Satuan
            $table->decimal('subtotal', 15, 2); // Subtotal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};