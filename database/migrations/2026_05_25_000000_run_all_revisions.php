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
        // 1. Update Tabel borrowers (PIN Verifikasi)
        if (Schema::hasTable('borrowers')) {
            Schema::table('borrowers', function (Blueprint $table) {
                if (!Schema::hasColumn('borrowers', 'pin')) {
                    $table->string('pin')->default('123456')->after('photo');
                }
            });
        }

        // 2. Update Tabel borrowings (OTP Verifikasi)
        if (Schema::hasTable('borrowings')) {
            Schema::table('borrowings', function (Blueprint $table) {
                if (!Schema::hasColumn('borrowings', 'verification_otp')) {
                    $table->string('verification_otp')->nullable()->after('borrowing_status');
                }
            });
        }

        // 3. Update Tabel tools (Harga Perolehan/Beli)
        if (Schema::hasTable('tools')) {
            Schema::table('tools', function (Blueprint $table) {
                if (!Schema::hasColumn('tools', 'purchase_price')) {
                    $table->decimal('purchase_price', 15, 2)->nullable()->after('purchase_date');
                }
            });
        }

        // 4. Update Tabel purchases (Harga Realisasi Total)
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                if (!Schema::hasColumn('purchases', 'realized_total_amount')) {
                    $table->decimal('realized_total_amount', 15, 2)->default(0)->after('total_amount');
                }
            });
        }

        // 5. Update Tabel purchase_items (Harga Realisasi Unit)
        if (Schema::hasTable('purchase_items')) {
            Schema::table('purchase_items', function (Blueprint $table) {
                if (!Schema::hasColumn('purchase_items', 'realized_unit_price')) {
                    $table->decimal('realized_unit_price', 15, 2)->default(0)->after('unit_price');
                }
            });
        }

        // 6. Membuat Tabel activity_logs (Audit Trail)
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('action');
                $table->text('description');
                $table->string('ip_address')->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop Activity Logs Table
        Schema::dropIfExists('activity_logs');

        // Drop added columns
        if (Schema::hasTable('borrowers')) {
            Schema::table('borrowers', function (Blueprint $table) {
                $table->dropColumn('pin');
            });
        }

        if (Schema::hasTable('borrowings')) {
            Schema::table('borrowings', function (Blueprint $table) {
                $table->dropColumn('verification_otp');
            });
        }

        if (Schema::hasTable('tools')) {
            Schema::table('tools', function (Blueprint $table) {
                $table->dropColumn('purchase_price');
            });
        }

        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('realized_total_amount');
            });
        }

        if (Schema::hasTable('purchase_items')) {
            Schema::table('purchase_items', function (Blueprint $table) {
                $table->dropColumn('realized_unit_price');
            });
        }
    }
};
