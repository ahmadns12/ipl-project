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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_seller')->constrained('users')->restrictOnDelete();
        $table->unsignedInteger('id_kategori');                        // harus sama tipe dengan categories.id (INT)
        $table->foreign('id_kategori')->references('id')->on('categories')->restrictOnDelete();
        $table->string('nama_produk', 200);
        $table->decimal('harga', 12, 2);
        $table->unsignedInteger('stok')->default(0);                   // UNSIGNED: stok tidak mungkin negatif
        $table->text('deskripsi')->nullable();
        $table->string('foto', 255)->nullable();
        $table->timestamps();
        $table->softDeletes();                                         // produk "dihapus" tetap aman bagi order lama

        $table->index('nama_produk');                                  // mempercepat pencarian (FR-PRD-03)
    });
}

public function down(): void
{
    Schema::dropIfExists('products');
}
};
