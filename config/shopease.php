<?php

return [
    'order_expire_hours' => (int) env('SHOPEASE_ORDER_EXPIRE_HOURS', 24),
    'va_prefix'          => env('SHOPEASE_VA_PREFIX', '8808'),

    // Simulasi RajaOngkir: tarif tetap per kurir
    'couriers' => [
        'jne'     => ['nama' => 'JNE Reguler',   'tarif' => 15000],
        'jnt'     => ['nama' => 'J&T Express',   'tarif' => 14000],
        'sicepat' => ['nama' => 'SiCepat Halu',  'tarif' => 12000],
    ],
];