<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => 'mail.kpa.ph',
        'secret' => 'key-43844631eb9b0f082e5033999fb69aa5',
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'KPAPostMail' => [
        'domain' => env('KPAPostMail_DOMAIN'),
        'email' => env('KPAPostMail_EMAIL'),
        'uid' => env('KPAPostMail_UID'),
    ],

    'BinaryLoops' => [
        'host' => env('BINARYLOOPS_HOST', 'binaryloops.kpa.ph'),
        'email' => env('BINARYLOOPS_EMAIL', 'kingpauloaquino@gmail.com'),
        'license' => env('BINARYLOOPS_LICENSE', 'tfnvK2sZZp1oEFD3TDAy1vP5A9R2vCaZphXF98nn1Qs'),
    ],

];
