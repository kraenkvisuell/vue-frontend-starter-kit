<?php

namespace Kraenkvisuell\ShopColor;

use Kraenkvisuell\ShopColor\Fieldtypes\ShopColor;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/css/app.css',
            'resources/js/shop-color.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $listen = [

    ];

    protected $fieldtypes = [
        ShopColor::class,
    ];

    public function bootAddon()
    {

    }

    public function register(): void
    {

    }
}
