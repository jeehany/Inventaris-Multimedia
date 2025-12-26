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
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('tool_code')->unique(); // Barcode aset
            $table->string('tool_name');
            $table->foreignId('category_id')->constrained('tool_categories');
            $table->string('current_condition'); // Baik, Rusak Ringan, Rusak Berat
            $table->enum('availability_status', ['available', 'borrowed', 'maintenance', 'disposed']);
            $table->foreignId('purchase_item_id')->nullable()->constrained('purchase_items')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
