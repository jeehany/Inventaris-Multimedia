<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('purchase_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
        // Kita simpan category_id agar nanti pas generate alat otomatis tahu kategorinya
        $table->foreignId('category_id')->constrained('tool_categories'); 
        $table->string('item_name'); // Nama barang yang dibeli (misal: Bor Bosch X500)
        $table->integer('quantity'); // Jumlah beli (misal: 10)
        $table->decimal('cost_per_unit', 15, 2);
        $table->decimal('total_price', 15, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
