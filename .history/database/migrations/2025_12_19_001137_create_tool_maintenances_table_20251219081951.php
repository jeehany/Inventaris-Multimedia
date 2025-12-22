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
        Schema::create('tool_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('tools');
            $table->date('maintenance_date');
            $table->foreignId('maintenance_type_id')->constrained('maintenance_types');
            $table->text('damage_description');
            $table->decimal('repair_cost', 15, 2)->default(0);
            $table->string('repaired_by'); // Nama bengkel/teknisi luar
            $table->foreignId('handled_by')->constrained('users'); // Admin yang urus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_maintenances');
    }
};
