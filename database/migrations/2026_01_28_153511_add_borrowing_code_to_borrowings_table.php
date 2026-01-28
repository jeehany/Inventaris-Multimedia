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
        Schema::table('borrowings', function (Blueprint $table) {
            $table->string('borrowing_code', 30)->nullable()->after('id');
        });

        // 2. Populate data existing
        $borrowings = \Illuminate\Support\Facades\DB::table('borrowings')->get();
        foreach ($borrowings as $b) {
            // Format: BRW-YYYYMMDD-Rand
            $date = $b->created_at ? date('Ymd', strtotime($b->created_at)) : date('Ymd');
            $code = 'BRW-' . $date . '-' . str_pad($b->id, 4, '0', STR_PAD_LEFT);
            
            \Illuminate\Support\Facades\DB::table('borrowings')
                ->where('id', $b->id)
                ->update(['borrowing_code' => $code]);
        }
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('borrowing_code');
        });
    }
};
