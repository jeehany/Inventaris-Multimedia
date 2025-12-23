<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. PERBAIKI TABEL TOOLS (Masalah di Image 4 & 7)
        if (Schema::hasTable('tools')) {
            Schema::table('tools', function (Blueprint $table) {
                // Cek apakah kolom status sudah ada? Jika belum, buatkan.
                if (!Schema::hasColumn('tools', 'status')) {
                    $table->string('status')->default('available')->after('tool_name');
                }
            });
        }

        // 2. PERBAIKI TABEL MAINTENANCES (Masalah di Image 6)
        if (Schema::hasTable('maintenances')) {
            Schema::table('maintenances', function (Blueprint $table) {
                // Cek apakah kolom maintenance_type_id sudah ada? Jika belum, buatkan.
                if (!Schema::hasColumn('maintenances', 'maintenance_type_id')) {
                    $table->foreignId('maintenance_type_id')->nullable()->after('tool_id');
                }
            });
        }
    }

    public function down()
    {
        // Kosongkan saja agar aman
    }
};