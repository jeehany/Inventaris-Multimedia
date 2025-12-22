<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('borrowing_items', function (Blueprint $table) {
            $table->id();
            // Kuncinya disini: Relasi ke Tabel Borrowings & Tools
            $table->foreignId('borrowing_id')->constrained('borrowings')->onDelete('cascade');
            $table->foreignId('tool_id')->constrained('tools');
            
            $table->string('tool_condition_before'); // Kondisi saat diambil
            $table->string('tool_condition_after')->nullable(); // Kondisi saat pulang
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_items');
    }
};
