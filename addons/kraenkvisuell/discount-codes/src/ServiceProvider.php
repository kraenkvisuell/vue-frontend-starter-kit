<?php

namespace Kraenkvisuell\DiscountCodes;

use Statamic\Providers\AddonServiceProvider;
use Kraenkvisuell\DiscountCodes\Fieldtypes\DiscountCodeUsages;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/css/app.css',
            'resources/js/discount-codes.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $fieldtypes = [
        DiscountCodeUsages::class,
    ];

    public function bootAddon()
    {

    }
}
