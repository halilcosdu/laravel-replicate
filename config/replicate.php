<?php

// config for HalilCosdu/Replicate
return [
    'api_token' => env('REPLICATE_API_TOKEN'),
    'api_url' => env('REPLICATE_API_URL', 'https://api.replicate.com/v1'),

    /*
     * Retrieve this value once from Replicate::defaultSecret() and cache it in
     * your environment. It is used to authenticate incoming webhook requests.
     */
    'webhook_secret' => env('REPLICATE_WEBHOOK_SECRET'),
    'webhook_tolerance' => (int) env('REPLICATE_WEBHOOK_TOLERANCE', 300),
];
