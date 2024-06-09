<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Site;

class CreateSkusCollection extends Command
{
    protected $signature = 'shop:create-skus-collection';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateCollection();

        $this->info('done creating skus collection.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'SKU',
            'tabs' => [
                'main' => [
                    'display' => 'Hauptteil',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Is visible',
                                        'localizable' => false,
                                        'default' => true,
                                        'width' => 50,
                                    ],
                                    'handle' => 'visible_in_shop',
                                ],
                                [
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Is available',
                                        'localizable' => false,
                                        'default' => true,
                                        'width' => 50,
                                    ],
                                    'handle' => 'is_available',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'SKU number',
                                        'localizable' => false,
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                        'width' => 50,
                                    ],
                                    'handle' => 'title',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'EAN',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 50,
                                    ],
                                    'handle' => 'ean',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Price incl. VAT',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 33,
                                    ],
                                    'handle' => 'formatted_price_incl_vat',
                                ],
                                [
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Has discount price',
                                        'localizable' => false,
                                        'default' => false,
                                        'width' => 33,
                                    ],
                                    'handle' => 'has_discount_price',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'if' => ['has_discount_price' => 'equals true'],
                                        'display' => 'Discount price incl. VAT',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 33,
                                    ],
                                    'handle' => 'formatted_discount_price_incl_vat',
                                ],
                                [
                                    'field' => [
                                        'icon' => 'entries',
                                        'mode' => 'default',
                                        'type' => 'entries',
                                        'max_items' => 1,
                                        'display' => 'Product',
                                        'localizable' => false,
                                        'collections' => ['products'],
                                    ],
                                    'handle' => 'product',
                                ],
                            ],
                        ],
                    ],
                ],
                'merchant' => [
                    'display' => 'Händler',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Merchant price excl. VAT',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 50,
                                    ],
                                    'handle' => 'formatted_merchant_price',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Season',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 50,
                                    ],
                                    'handle' => 'season_name',
                                ],
                                [
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Is preorder',
                                        'localizable' => false,
                                        'default' => false,
                                        'width' => 50,
                                    ],
                                    'handle' => 'is_preorder',
                                ],
                                [
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Is visible for merchants',
                                        'localizable' => false,
                                        'default' => true,
                                        'width' => 50,
                                    ],
                                    'handle' => 'visible_for_merchants',
                                ],
                            ],
                        ],
                    ],
                ],
                'sidebar' => [
                    'display' => 'Sidebar',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Slug',
                                        'localizable' => false,
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                    ],
                                    'handle' => 'slug',
                                ],
                                [
                                    'field' => [
                                        'type' => 'terms',
                                        'mode' => 'select',
                                        'display' => 'Colors',
                                        'localizable' => false,
                                        'taxonomies' => ['colors'],
                                    ],
                                    'handle' => 'colors',
                                ],
                                [
                                    'field' => [
                                        'type' => 'terms',
                                        'mode' => 'select',
                                        'display' => 'Color Groups',
                                        'localizable' => false,
                                        'taxonomies' => ['color_groups'],
                                    ],
                                    'handle' => 'color_groups',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $blueprint = Blueprint::make('sku')
            ->setContents($contents)
            ->setNamespace('collections.skus');

        $blueprint->save();
    }

    protected function createOrUpdateCollection()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $collection = Collection::make('skus');

        $collection
            ->title('SKUs')
            ->dated(false)
            ->requiresSlugs(false)
            ->routes('/skus/{slug}')
            ->structure(null)
            ->sites($sites)
            ->searchIndex('skus')
            ->defaultPublishState(true)
            ->propagate(true);

        $collection->save();
    }
}
