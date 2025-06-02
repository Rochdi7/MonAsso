<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users', // consistent with defined provider
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users', // uses Membre model
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Membre::class, // your custom table 'members'
        ],
    ],

    'passwords' => [
        'users' => [ // match with provider 'users'
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
