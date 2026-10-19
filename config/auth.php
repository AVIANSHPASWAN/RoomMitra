
<?php

use App\Models\User;
use App\Models\Owner;
use App\Models\Admin;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [

        // Normal User
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Room Owner
        'owner' => [
            'driver' => 'session',
            'provider' => 'owners',
        ],

        // Admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        // Normal Users table
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        // Room Owners table
        'owners' => [
            'driver' => 'eloquent',
            'model' => Owner::class,
        ],

        // Admins table
        'admins' => [
            'driver' => 'eloquent',
            'model' => Admin::class,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Password Resetting
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env(
                'AUTH_PASSWORD_RESET_TOKEN_TABLE',
                'password_reset_tokens'
            ),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
