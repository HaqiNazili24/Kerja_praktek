<?php

return [
    'mailers' => [
        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],
    ],
    'default' => env('MAIL_MAILER', 'log'),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@jagatnusantara.test'),
        'name' => env('MAIL_FROM_NAME', 'Toko Beras Jagat Nusantara'),
    ],
];
