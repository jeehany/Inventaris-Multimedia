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
        Schema::table('borrowings', function (Blueprint $table) {
            // Menambahkan kolom notes yang boleh kosong (nullable)
            $table->text('notes')->nullable()->after('borrowing_status');
        });
    }

    public function down()
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};
