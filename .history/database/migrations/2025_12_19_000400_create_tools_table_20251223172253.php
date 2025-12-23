<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Alat
            
            // PERBAIKAN DI SINI:
            // Kita hubungkan ke 'tool_categories' (bukan categories)
            $table->foreignId('tool_category_id')->nullable()->constrained('tool_categories');
            
            // Kita hubungkan ke 'vendors'
            $table->foreignId('vendor_id')->nullable()->constrained('vendors');
            
            $table->string('serial_number')->nullable();
            $table->text('description')->nullable();
            $table->string('condition')->default('baik'); // baik, rusak, hilang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};