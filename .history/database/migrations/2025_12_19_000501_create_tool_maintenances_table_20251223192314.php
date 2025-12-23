<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Alat & User (Pelapor)
            $table->foreignId('tool_id')->constrained('tools')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            
            $table->date('start_date'); // Tanggal mulai perbaikan
            $table->date('end_date')->nullable(); // Tanggal selesai
            
            $table->text('note'); // Deskripsi kerusakan
            $table->string('status')->default('in_progress'); // in_progress, completed
            
            // Opsional: Biaya perbaikan
            $table->decimal('cost', 15, 2)->default(0); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};