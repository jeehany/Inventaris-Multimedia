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
        if (Schema::hasTable('borrowers')) {
            Schema::table('borrowers', function (Blueprint $table) {
                if (!Schema::hasColumn('borrowers', 'nik')) {
                    $table->string('nik')->nullable()->after('name');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('borrowers')) {
            Schema::table('borrowers', function (Blueprint $table) {
                $table->dropColumn('nik');
            });
        }
    }
};
