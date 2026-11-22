<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_order')->unique()->constrained('orders')->cascadeOnDelete();  // Order 1–1 Review
        $table->foreignId('id_buyer')->constrained('users')->cascadeOnDelete();
        $table->unsignedTinyInteger('rating');                          // 1–5
        $table->text('komentar')->nullable();
        $table->timestamps();
    });

    if (DB::getDriverName() === 'mysql') {                              // CHECK constraint (MySQL 8.0.16+)
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5)');
    }
}

public function down(): void
{
    Schema::dropIfExists('reviews');
}
};
