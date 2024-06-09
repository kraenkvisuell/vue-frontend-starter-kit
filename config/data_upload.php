<?php

return [
    'folders' => [
        'skus' => 'artikel',
        'merchants' => 'haendler',
        'discount_codes' => 'gutscheincodes',
        'product_suggestions' => 'produktempfehlung',
        'merchant_history' => 'auftrag_pos',
        'merchant_addresses' => 'adressen',
    ],

    'product_csv' => [
        'recipients' => env('APP_PRODUCT_CSV_EMAIL_ADDRESSES', null)
    ],

    'products' => [
        'count_fields' => 24,
        'recipients' => env('APP_PRODUCT_UPLOAD_EMAIL_ADDRESSES', null)
    ],

    'merchants' => [
        'count_fields' => 10,
        'recipients' => env('APP_MERCHANT_UPLOAD_EMAIL_ADDRESSES', null)
    ],

    'merchant_addresses' => [
        'count_fields' => 7,
        'recipients' => env('APP_MERCHANT_UPLOAD_EMAIL_ADDRESSES', null)
    ],

    'csv_filename_begin' => 'zwei',

    'default_country_iso' => 'DE',

    'send_merchant_notifications' => env('APP_SEND_MERCHANT_NOTIFICATIONS', false)
];
