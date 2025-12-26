<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- WAJIB ADA

return new class extends Migration
{
    public function up(): void
    {
        // Perintah ini memaksa kolom untuk menerima status 'disposed'
        // Pastikan semua status lama Anda (available, borrowed, maintenance) ada di sini
        DB::statement("ALTER TABLE tools MODIFY COLUMN availability_status ENUM('available', 'borrowed', 'maintenance', 'missing', 'disposed') NOT NULL DEFAULT 'available'");
    }

    public function down(): void
    {
        // Kembalikan ke kondisi lama jika rollback
        DB::statement("ALTER TABLE tools MODIFY COLUMN availability_status ENUM('available', 'borrowed', 'maintenance', 'missing') NOT NULL DEFAULT 'available'");
    }
};