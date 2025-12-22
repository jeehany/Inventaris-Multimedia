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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->date('purchase_date');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->decimal('total_cost', 15, 2)->default(0);
            
            // INI KUNCI FITUR APPROVAL KAMU
            $table->foreignId('created_by')->constrained('users'); // Admin yang input
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Kepala yang setujui

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
