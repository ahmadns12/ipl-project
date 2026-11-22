<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    foreach (['Elektronik', 'Fashion', 'Buku', 'Rumah Tangga', 'Olahraga', 'Makanan & Minuman'] as $nama) {
        Category::firstOrCreate(['slug' => Str::slug($nama)], ['nama_kategori' => $nama]);
    }
}
}
