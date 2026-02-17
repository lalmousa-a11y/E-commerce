<?php

return [
    'gateway' => env('PAYMENT_GATEWAY', 'stripe'),
    
    'stripe' => [
        'api_key' => env('STRIPE_API_KEY'),
        'secret_key' => env('STRIPE_SECRET_KEY'),
    ],
    
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
    ],
];
