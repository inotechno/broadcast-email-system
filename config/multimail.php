<?php

return [
    /*
    |--------------------------------------------------------------------------
    | List your email providers
    |--------------------------------------------------------------------------
    |
    | Enjoy a life with multimail
    |
    */
    'use_default_mail_facade_in_tests' => true,

    'emails'  => [
        'sales@ads.rumahaplikasi.co.id' => [
            'pass'          => env('MAIL_ADS_PASSWORD'),
            'username'      => env('MAIL_ADS_USERNAME'),
            'from_name'     => 'Rumah Aplikasi',
        ],
        'sales@app.rumahaplikasi.co.id'  => [
            'pass'          => env('MAIL_APP_PASSWORD'),
            'username'      => env('MAIL_APP_USERNAME'),
            'from_name'     => 'Rumah Aplikasi',
        ],
        'no-reply@marketing.psikotesdaring.com'  => [
            'pass'          => env('MAIL_MARKETING_PASSWORD'),
            'username'      => env('MAIL_MARKETING_USERNAME'),
            'from_name'     => 'Psikotes Daring',
        ],
        'no-reply@ads.psikotesdaring.com'  => [
            'pass'          => env('MAIL_ADS_PSIKOTES_PASSWORD'),
            'username'      => env('MAIL_ADS_PSIKOTES_USERNAME'),
            'from_name'     => 'Psikotes Daring',
        ],
        'no-reply@info.psikotesdaring.com'  => [
            'pass'          => env('MAIL_INFO_PASSWORD'),
            'username'      => env('MAIL_INFO_USERNAME'),
            'from_name'     => 'Psikotes Daring',
        ],
    ],

    'provider' => [
        'default' => [
            'host'      => env('MAIL_HOST'),
            'port'      => env('MAIL_PORT'),
            'encryption' => env('MAIL_ENCRYPTION'),
        ],
    ],

];
