<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $seller = User::where('email', 'seller@shopease.test')->first();
    $kategori = Category::pluck('id', 'slug');

    $data = [
        ['Headphone Bluetooth X1',  'elektronik',   350000, 25, 'Headphone nirkabel dengan baterai 30 jam.'],
        ['Kaos Polos Premium',      'fashion',       85000, 100, 'Katun combed 30s, nyaman dipakai harian.'],
        ['Novel Laskar Pelangi',    'buku',          75000, 40, 'Novel karya Andrea Hirata.'],
        ['Blender Serbaguna 1.5L',  'rumah-tangga', 275000, 15, 'Blender 3 kecepatan, pisau stainless.'],
        ['Sepatu Lari Ringan',      'olahraga',     420000, 30, 'Sol empuk, cocok untuk lari jarak jauh.'],
        ['Kopi Arabika 250g',       'makanan-minuman', 65000, 60, 'Biji kopi arabika sangrai medium.'],
    ];

    foreach ($data as [$nama, $slug, $harga, $stok, $desk]) {
        Product::firstOrCreate(
            ['id_seller' => $seller->id, 'nama_produk' => $nama],
            ['id_kategori' => $kategori[$slug], 'harga' => $harga, 'stok' => $stok, 'deskripsi' => $desk]
        );
    }
}
}
