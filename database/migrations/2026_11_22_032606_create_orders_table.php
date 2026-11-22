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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // --- kolom sesuai SDD ---
        $table->foreignId('id_buyer')->constrained('users')->restrictOnDelete();
        $table->foreignId('id_product')->constrained('products')->restrictOnDelete();
        $table->decimal('total_harga', 12, 2);                          // harga_satuan * jumlah + ongkir
        $table->string('status_pembayaran', 30)->default('pending');
        $table->string('nomor_resi', 60)->nullable();
        $table->string('status_pengiriman', 30)->default('waiting');
        $table->timestamp('created_at')->nullable();
        // --- kolom pendukung alur SRS/SDD ---
        $table->string('invoice_number', 30)->index();                  // sama untuk semua item dalam 1 checkout
        $table->unsignedInteger('jumlah');
        $table->decimal('harga_satuan', 12, 2);                         // snapshot harga saat checkout
        $table->decimal('ongkir', 12, 2)->default(0);
        $table->string('kurir', 30);
        $table->text('alamat_pengiriman');
        $table->string('va_number', 30)->nullable()->index();
        $table->timestamp('batas_bayar')->nullable();                   // created_at + 24 jam
        $table->timestamp('paid_at')->nullable();
        $table->timestamp('shipped_at')->nullable();
        $table->timestamp('completed_at')->nullable();
        $table->timestamp('updated_at')->nullable();

        $table->index(['status_pembayaran', 'status_pengiriman']);
    });
}

public function down(): void
{
    Schema::dropIfExists('orders');
}
};
