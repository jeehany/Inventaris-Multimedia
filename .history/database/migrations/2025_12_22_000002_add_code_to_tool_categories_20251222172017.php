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
        Schema::table('tool_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('tool_categories', 'code')) {
                $table->string('code', 10)->nullable()->unique()->after('category_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tool_categories', function (Blueprint $table) {
            if (Schema::hasColumn('tool_categories', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};
