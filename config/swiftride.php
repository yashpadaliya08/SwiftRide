<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SwiftRide Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for SwiftRide car rental system
    |
    */

    'admin_email' => env('ADMIN_EMAIL', 'swiftride15@gmail.com'),

    'booking' => [
        'buffer_hours' => env('BOOKING_BUFFER_HOURS', 8),
        'cities' => [
            'Rajkot',
            'Ahmedabad',
            'Vadodara',
            'Surat',
            'Jamnagar',
        ],
    ],
];

