<?php

namespace Kraenkvisuell\Translatable;

use Kraenkvisuell\Translatable\Fieldtypes\Translatable;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/css/app.css',
            'resources/js/translatable.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $fieldtypes = [
        Translatable::class,
    ];

    public function bootAddon()
    {
        // $this->publishes([
        //     __DIR__.'/../config/translatable.php' => config_path('translatable.php'),
        // ], 'translatable');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'translatable');
    }
}
