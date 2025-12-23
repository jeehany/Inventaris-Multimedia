<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Perbaiki Tabel Tools (Tambah status)
        if (Schema::hasTable('tools')) {
            Schema::table('tools', function (Blueprint $table) {
                if (!Schema::hasColumn('tools', 'status')) {
                    // Default 'available' supaya alat yang sudah ada dianggap tersedia
                    $table->string('status')->default('available')->after('tool_name');
                }
            });
        }

        // 2. Perbaiki Tabel Maintenances (Tambah maintenance_type_id)
        if (Schema::hasTable('maintenances')) {
            Schema::table('maintenances', function (Blueprint $table) {
                if (!Schema::hasColumn('maintenances', 'maintenance_type_id')) {
                    $table->foreignId('maintenance_type_id')
                          ->nullable()
                          ->after('tool_id'); // Tidak perlu constrained dulu biar aman
                }
            });
        }
    }

    public function down()
    {
        // Hapus kolom jika rollback
        if (Schema::hasColumn('tools', 'status')) {
            Schema::table('tools', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
        
        if (Schema::hasColumn('maintenances', 'maintenance_type_id')) {
            Schema::table('maintenances', function (Blueprint $table) {
                $table->dropColumn('maintenance_type_id');
            });
        }
    }
};