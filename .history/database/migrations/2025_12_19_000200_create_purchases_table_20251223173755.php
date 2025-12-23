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

            $table->string('purchase_code')->unique(); // Kode Transaksi, misal PO-2023-001

            $table->date('purchase_date');

            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users'); // Siapa admin yang input

            $table->text('notes')->nullable();

            $table->decimal('total_amount', 15, 2)->default(0); // Total harga

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

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