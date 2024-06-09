<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'lang' => [
            'driver' => 'local',
            'root' => base_path('resources/lang'),
        ],

        'resources' => [
            'driver' => 'local',
            'root' => base_path('resources'),
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'import_data' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'zwei_uploads',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'import_files' => [
            'driver' => 's3',
            'key' => env('DO_IMPORT_FILES_KEY'),
            'secret' => env('DO_IMPORT_FILES_SECRET'),
            'endpoint' => env('DO_IMPORT_FILES_ENDPOINT'),
            'region' => env('DO_IMPORT_FILES_REGION'),
            'bucket' => env('DO_IMPORT_FILES_BUCKET'),
            'visibility' => 'public',
        ],

        'sku_import_files' => [
            'driver' => 'sftp',
            'host' => env('SFTP_IMPORT_HOST'),
            'username' => env('SFTP_IMPORT_USER'),
            'password' => env('SFTP_IMPORT_PASSWORD'),
            'port' => 22,
        ],

        'assets' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'shop/assets',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'lasso' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'shop/lasso',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'videos' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'shop/videos',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'articles' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'shop/articles',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'media' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'shop/media',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'optimized' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'shop/optimized',
            'cdn' => env('DO_SPACES_CDN'),
            'visibility' => 'public',
        ],

        'xml_orders' => [
            'driver' => 'sftp',
            'host' => env('XML_ORDER_SFTP_HOST'),
            'username' => env('XML_ORDER_SFTP_USER'),
            'password' => env('XML_ORDER_SFTP_PASSWORD'),

            // Settings for SSH key based authentication...
            // 'privateKey' => '/path/to/privateKey',
            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            // 'root' => '',
            // 'timeout' => 30,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
