<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $buyer    = User::where('email', 'buyer@shopease.test')->first();
    $products = Product::take(4)->get();

    $skenario = [
        ['pending',   'waiting',   null],            // Pending Payment
        ['paid',      'waiting',   null],            // Paid → siap diinput resi Seller
        ['paid',      'shipped',   'JNE-9912048'],   // Shipped → siap dikonfirmasi Buyer
        ['paid',      'completed', 'JNE-9912049'],   // Completed → siap diulas
    ];

    foreach ($skenario as $i => [$bayar, $kirim, $resi]) {
        $p = $products[$i];
        Order::create([
            'id_buyer'          => $buyer->id,
            'id_product'        => $p->id,
            'invoice_number'    => 'INV-SEED-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
            'jumlah'            => 1,
            'harga_satuan'      => $p->harga,
            'ongkir'            => 15000,
            'total_harga'       => $p->harga + 15000,
            'kurir'             => 'jne',
            'alamat_pengiriman' => $buyer->alamat,
            'status_pembayaran' => $bayar,
            'status_pengiriman' => $kirim,
            'nomor_resi'        => $resi,
            'va_number'         => config('shopease.va_prefix') . '000000' . ($i + 1),
            'batas_bayar'       => now()->addHours(24),
            'paid_at'           => $bayar === 'paid' ? now() : null,
        ]);
    }
}
}
