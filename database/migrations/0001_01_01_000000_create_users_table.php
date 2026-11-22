<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                              // BIGINT PK
            $table->string('nama', 150);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
            $table->enum('peran', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->string('nomor_telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('is_active')->default(true);               // tambahan: keaktifan akun (Admin)
            $table->decimal('saldo', 14, 2)->default(0);               // tambahan: saldo Seller (Seq. 3.4.2)
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};