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
        
        // Relasi ke tabel Tools (Alat apa yang diperbaiki?)
        $table->foreignId('tool_id')->constrained('tools')->onDelete('cascade');
        
        // Relasi ke tabel Maintenance Types (Jenis perbaikannya apa?) -> INI YANG TADI HILANG
        $table->foreignId('maintenance_type_id')->constrained('maintenance_types')->onDelete('cascade');
        
        // Relasi ke User (Siapa yang lapor?)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->date('start_date');
        $table->date('end_date')->nullable(); // Boleh kosong kalau belum selesai
        $table->text('note'); // Keterangan kerusakan
        $table->decimal('cost', 15, 2)->default(0); // Biaya perbaikan
        $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');
        
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};