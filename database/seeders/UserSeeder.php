<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $akun = [
        ['nama' => 'Admin ShopEase', 'email' => 'admin@shopease.test',  'peran' => 'admin'],
        ['nama' => 'Toko Maju Jaya', 'email' => 'seller@shopease.test', 'peran' => 'seller'],
        ['nama' => 'Budi Pembeli',   'email' => 'buyer@shopease.test',  'peran' => 'buyer'],
    ];

    foreach ($akun as $a) {
        User::updateOrCreate(['email' => $a['email']], $a + [
            'password_hash' => 'password',            // di-hash otomatis oleh cast
            'nomor_telepon' => '081234567890',
            'alamat'        => 'Jl. Merdeka No. 1, Bandung, Jawa Barat 40111',
        ]);
    }
}
}
