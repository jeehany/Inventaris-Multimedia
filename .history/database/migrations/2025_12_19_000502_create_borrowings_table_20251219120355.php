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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            // Relasi ke Peminjam (Borrower)
            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');
            
            // Relasi ke User yang memproses (Admin/Petugas)
            $table->foreignId('user_id')->constrained('users'); 

            $table->date('borrow_date');            // Tanggal Pinjam
            $table->date('planned_return_date');    // Rencana Kembali
            $table->date('actual_return_date')->nullable(); // Realisasi Kembali
            
            // Status: dipinjam, dikembalikan, telat
            $table->string('borrowing_status')->default('active'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
