<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('catalog.index'));

// Setiap anggota punya file route sendiri, tidak saling menyentuh web.php
foreach (glob(__DIR__ . '/modules/*.php') as $file) {
    require $file;
}
