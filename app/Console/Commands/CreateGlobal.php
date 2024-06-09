<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;

class CreateGlobal extends Command
{
    protected $signature = 'shop:create-global';

    public function handle()
    {
        $globals = GlobalSet::findByHandle('shop');

        if (! $globals) {
            $globals = GlobalSet::make('shop')->title('Shop-Settings');
        }

        $sites = Site::all()->pluck('handle')->toArray();

        foreach ($sites as $handle) {
            $variables = $globals->makeLocalization($handle);
            $variables->data([
                'shop_title' => 'Shop',
            ]);
            $variables->origin($handle != 'default' ? 'default' : null);
            $globals->addLocalization($variables);
        }
        $globals->save();

        $contents = [
            'title' => 'Shop Settings',
            'tabs' => [
                'main' => [
                    'display' => 'Hauptteil',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Shop Title',
                                        'localizable' => true,
                                    ],
                                    'handle' => 'shop_title',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Product Category Title (singular)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'product_category_singular',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Product Category Title (plural)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'product_category_plural',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Product Group Title (singular)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'product_group_singular',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Product Group Title (plural)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'product_group_plural',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Product Title (singular)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'product_singular',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Product Title (plural)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'product_plural',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'SKU Title (singular)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'sku_singular',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'SKU Title (plural)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'sku_plural',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'SKU number title (singular)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'sku_number_singular',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'SKU number title (plural)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'sku_number_plural',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Packgaging title (singular)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'packaging_singular',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Packgaging title (plural)',
                                        'width' => 50,
                                        'localizable' => true,
                                    ],
                                    'handle' => 'packaging_plural',
                                ],
                            ],
                        ],
                    ],
                ],
                'vat' => [
                    'display' => 'VAT',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Default VAT',
                                        'localizable' => false,
                                    ],
                                    'handle' => 'default_vat_percentage',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $blueprint = Blueprint::make('shop')
            ->setContents($contents)
            ->setNamespace('globals');

        $blueprint->save();

        $this->info('done creating global.');
    }
}
