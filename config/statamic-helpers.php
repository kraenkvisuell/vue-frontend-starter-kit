<?php

return [
    'with_shop_addon' => true,
    'local' => [
        'assets_path' => 'storage/app/public',
    ],
    'remote' => [
        'staging' => [
            'ssh_user' => 'forge',
            'ssh_host' => '1.2.3.5',
            'ssh_path' => 'home/forge/your-staging-domain.com',
            'assets_path' => 'storage/app/public',
        ],
        'production' => [
            'ssh_user' => 'forge',
            'ssh_host' => '1.2.3.5',
            'ssh_path' => 'home/forge/your-production-domain.com',
            'assets_path' => 'storage/app/public',
        ],
    ],

    'preset_on_upload' => true,
    'preset_disk' => 'presets',
    'presets' => [
        'xs' => ['w' => 200, 'h' => 200, 'q' => 90, 'fit' => 'max'],
        'sm' => ['w' => 400, 'h' => 400, 'q' => 90, 'fit' => 'max'],
        'base' => ['w' => 800, 'h' => 800, 'q' => 90, 'fit' => 'max'],
        'lg' => ['w' => 1600, 'h' => 1600, 'q' => 90, 'fit' => 'max'],
        'xl' => ['w' => 2400, 'h' => 2400, 'q' => 90, 'fit' => 'max'],
    ],
];
