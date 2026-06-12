<?php

return [
    'name' => env('APP_NAME', 'Toko Beras Jagat Nusantara'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'en',
    'faker_locale' => 'id_ID',
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [],
    'maintenance' => [
        'driver' => 'file',
    ],
    'store' => [
        'name' => env('STORE_NAME', 'Toko Beras Jagat Nusantara'),
        'bank_name' => env('STORE_BANK_NAME', 'Bank BCA'),
        'bank_account' => env('STORE_BANK_ACCOUNT', '1234567890'),
        'bank_holder' => env('STORE_BANK_HOLDER', 'Toko Beras Jagat Nusantara'),
        'shipping_flat_rate' => (int) env('SHIPPING_FLAT_RATE', 15000),
    ],
];
