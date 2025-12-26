<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            
            // Kolom ini disesuaikan PERSIS dengan Error Log Anda
            $table->string('purchase_code');   // Kodingan Anda cari ini
            $table->date('purchase_date');     // Kodingan Anda cari ini (bukan 'date')
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('tool_id')->constrained('tools');
            $table->string('status');
            $table->decimal('total_amount', 15, 2);
            $table->foreignId('user_id')->constrained('users');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};