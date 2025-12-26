public function up(): void
{
    Schema::table('tools', function (Blueprint $table) {
        $table->softDeletes(); // Menambahkan kolom deleted_at
    });
}

public function down(): void
{
    Schema::table('tools', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}