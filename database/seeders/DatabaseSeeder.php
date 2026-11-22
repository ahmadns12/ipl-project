<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        CategorySeeder::class,
        UserSeeder::class,
        ProductSeeder::class,
        OrderSeeder::class,     // data demo agar Modul D bisa jalan tanpa menunggu Modul C
    ]);
}
}
