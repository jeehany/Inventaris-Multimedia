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
    Schema::table('maintenances', function (Blueprint $table) {
        // Tambahkan kolom foreign key (nullable dulu biar aman jika ada data lama)
        $table->foreignId('maintenance_type_id')->nullable()->after('tool_id')->constrained('maintenance_types')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('maintenances', function (Blueprint $table) {
        $table->dropForeign(['maintenance_type_id']);
        $table->dropColumn('maintenance_type_id');
    });
}
};
