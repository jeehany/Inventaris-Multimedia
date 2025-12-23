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
            
            // KOLOM-KOLOM INI DISESUAIKAN DENGAN ERROR LOG MAS:
            $table->foreignId('category_id')->nullable()->constrained('tool_categories'); // Tadi 'tool_category_id'
            $table->string('tool_name');      // Tadi 'item_name'
            $table->string('specification')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2); // Tadi 'price'
            $table->decimal('subtotal', 15, 2);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};