<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code')->unique();
            $table->date('date');
            
            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Staff yang mengajukan
            $table->unsignedBigInteger('vendor_id')->nullable(); // Opsional di awal RAB
            
            // Total amount
            $table->decimal('total_amount', 15, 2)->default(0); // Total RAB
            
            // Kolom Status (Sesuai Skripsi: pending_head, approved_head, completed, rejected)
            $table->string('status')->default('pending_head'); 
            
            // Kolom Bukti & Catatan
            $table->string('transaction_proof_photo')->nullable(); // Nota dari toko setelah completed
            $table->text('rejection_note')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};