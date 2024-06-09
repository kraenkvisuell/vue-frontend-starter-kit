<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default search index
    |--------------------------------------------------------------------------
    |
    | This option controls the search index that gets queried when performing
    | search functions without explicitly selecting another index.
    |
    */

    'default' => 'all',

    /*
    |--------------------------------------------------------------------------
    | Search Indexes
    |--------------------------------------------------------------------------
    |
    | Here you can define all of the available search indexes.
    |
    */

    'indexes' => [
        'all' => [
            'driver' => env('STATAMIC_DEFAULT_SEARCH_DRIVER', 'local'),
            'searchables' => ['runway:*', 'collection:pages'],
            'fields' => ['title', 'code'],
        ],

        'pages' => [
            'driver' => env('STATAMIC_DEFAULT_SEARCH_DRIVER', 'local'),
            'searchables' => ['collection:pages'],
            'fields' => ['title', 'blocks'],
        ],

        'jobs' => [
            'driver' => env('STATAMIC_DEFAULT_SEARCH_DRIVER', 'local'),
            'searchables' => ['collection:jobs'],
            'fields' => ['title'],
        ],

        'mail_templates' => [
            'driver' => env('STATAMIC_DEFAULT_SEARCH_DRIVER', 'local'),
            'searchables' => ['collection:mail_templates'],
            'fields' => ['title'],
        ],

        'discount_codes' => [
            'driver' => env('STATAMIC_DEFAULT_SEARCH_DRIVER', 'local'),
            'searchables' => ['runway:discountCode'],
            'fields' => ['code'],
        ],

        'products' => [
            'driver' => env('STATAMIC_DEFAULT_SEARCH_DRIVER', 'local'),
            'searchables' => ['runway:product'],
            'fields' => ['title'],
        ],

        // 'blog' => [
        //     'driver' => 'local',
        //     'searchables' => 'collection:blog',
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | that use the corresponding driver. For instance, if you have two
    | indexes that use the "local" driver, both of them can have the
    | same base configuration. You may override for each index.
    |
    */

    'drivers' => [

        'local' => [
            'path' => storage_path('statamic/search'),
        ],

        'algolia' => [
            'credentials' => [
                'id' => env('ALGOLIA_APP_ID', ''),
                'secret' => env('ALGOLIA_SECRET', ''),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Search Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | regardless of the driver. You can override these per driver or per index.
    |
    */

    'defaults' => [
        'fields' => ['title'],
    ],

];
