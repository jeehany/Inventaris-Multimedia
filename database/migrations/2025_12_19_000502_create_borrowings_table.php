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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Peminjam (Siswa/Guru)
            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');
            
            // Relasi ke User (Admin yang melayani) - INI YANG TADI BIKIN ERROR
            $table->foreignId('user_id')->constrained('users'); 
            
            $table->date('borrow_date');
            $table->date('planned_return_date');
            $table->date('actual_return_date')->nullable();
            $table->string('borrowing_status'); // active, returned, overdue
            $table->text('notes')->nullable();
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