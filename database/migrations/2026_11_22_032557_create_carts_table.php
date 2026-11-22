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
    Schema::create('carts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_buyer')->constrained('users')->cascadeOnDelete();
        $table->foreignId('id_product')->constrained('products')->cascadeOnDelete();
        $table->unsignedInteger('jumlah')->default(1);
        $table->timestamps();

        $table->unique(['id_buyer', 'id_product']);                    // 1 produk = 1 baris per buyer
    });
}

public function down(): void
{
    Schema::dropIfExists('carts');
}
};
