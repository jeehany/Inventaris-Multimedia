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
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                if (!Schema::hasColumn('purchases', 'purchase_code')) {
                    $table->string('purchase_code')->unique()->after('id');
                }
                if (!Schema::hasColumn('purchases', 'purchase_date')) {
                    $table->date('purchase_date')->nullable()->after('purchase_code');
                }
                if (!Schema::hasColumn('purchases', 'vendor_id')) {
                    $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('set null')->after('purchase_date');
                }
                if (!Schema::hasColumn('purchases', 'total_amount')) {
                    $table->decimal('total_amount', 15, 2)->default(0)->after('notes');
                }
                if (!Schema::hasColumn('purchases', 'notes')) {
                    $table->text('notes')->nullable()->after('user_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                if (Schema::hasColumn('purchases', 'purchase_code')) {
                    $table->dropUnique(['purchase_code']);
                    $table->dropColumn('purchase_code');
                }
                if (Schema::hasColumn('purchases', 'purchase_date')) {
                    $table->dropColumn('purchase_date');
                }
                if (Schema::hasColumn('purchases', 'vendor_id')) {
                    $table->dropForeign(['vendor_id']);
                    $table->dropColumn('vendor_id');
                }
                if (Schema::hasColumn('purchases', 'total_amount')) {
                    $table->dropColumn('total_amount');
                }
                if (Schema::hasColumn('purchases', 'notes')) {
                    $table->dropColumn('notes');
                }
            });
        }
    }
};
