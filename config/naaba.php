<?php

return [

    /*|--------------------------------------------------------------------------
    | Naaba Configuration
    |--------------------------------------------------------------------------
    || This file contains the configuration settings for any Naaba application.
    | It includes settings for author information, application name,
    | description, keywords, version, URLs, and maintenance mode.
    | You can modify these settings as per your requirements.
    | Make sure to keep the keys consistent with the application logic.
    | You can also set the maintenance mode and debug mode here.
    | The configuration values can be accessed using the `config()` helper function.
    | For example, `config('naaba.app_name')` will return the application name.
    | This file is loaded automatically by the framework during the application bootstrapping process.
    |--------------------------------------------------------------------------*/

    'author' => 'Naaba Technologies LLC',
    'author_short' => 'Naaba Techs',
    'author_url' => 'https://naabatechs.com',
    'author_email' => 'info.jabaapplets@gmail.com',
    'author_phone' => '+233 599 621 751',
    'author_address' => '704 Polo Dr. N, Columbus, Ohio, 43229, United States',
    'author_social' => [
        'twitter' => 'https://x.com/naabatechs',
        'facebook' => 'https://www.facebook.com/naabatechs',
        'instagram' => 'https://www.instagram.com/naabatechs',
        'linkedin' => 'https://linkedin.com/company/naabatechs',
    ],

    'app_name' => 'Lost & Found',
    'short_name' => 'LoFo',
    'description' => 'Lost & Found - Your trusted platform for lost items.',
    'keywords' => 'lost and found, lost items, claim lost items, report lost items',
    'version' => '1.0.6',
    'app_url' => 'https://lofo.naabatechs.com',
    'geo_region' => 'OH',
    'app_store_id' => '1234567890',
    'play_store_id' => 'com.naabatechs.lofo',
    'app_store_url' => 'https://apps.apple.com/app/id1234567890',
    'play_store_url' => 'https://play.google.com/store/apps/details?id=com.naabatechs.lofo',
    'geo_country' => 'United States',
    'geo_city' => 'Columbus',
    'geo_postal_code' => '43229',
    'geo_street_address' => '704 Polo Dr. N',
    'geo_latitude' => '40.7128',
    'geo_longitude' => '-74.0060',

    'app_main_color' => '#3B82F6',
    'app_secondary_color' => '#00a63e',
    'app_tertiary_color' => '#F3F4F6',
    'app_logo' => 'logo.png',
    'app_favicon' => 'favicon.ico',
    'app_apple_touch_icon' => 'apple-touch-icon.png',
    'app_manifest' => 'site.webmanifest',
    'maintenance_mode' => env('APP_MAINTENANCE_MODE', false),
    'maintenance_message' => 'The application is currently undergoing maintenance. Please check back later.',
    'debug_mode' => env('APP_DEBUG', false),
    'log_level' => env('APP_LOG_LEVEL', 'debug'),
];
