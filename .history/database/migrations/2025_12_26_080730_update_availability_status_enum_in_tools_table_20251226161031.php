<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- PENTING: Jangan lupa import ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kita ubah kolom ENUM untuk menambahkan 'disposed'
        // Pastikan Anda mendaftar SEMUA status yang lama juga ('available', 'borrowed', 'maintenance', dll)
        // Saya asumsikan status lama Anda adalah available, borrowed, maintenance, dan missing.
        
        DB::statement("ALTER TABLE tools MODIFY COLUMN availability_status ENUM('available', 'borrowed', 'maintenance', 'missing', 'disposed') NOT NULL DEFAULT 'available'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke kondisi semula (tanpa 'disposed')
        // Hati-hati: Data yang statusnya 'disposed' bisa error jika di-rollback
        DB::statement("ALTER TABLE tools MODIFY COLUMN availability_status ENUM('available', 'borrowed', 'maintenance', 'missing') NOT NULL DEFAULT 'available'");
    }
};