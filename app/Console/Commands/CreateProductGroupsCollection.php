<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Site;

class CreateProductGroupsCollection extends Command
{
    protected $signature = 'shop:create-product-groups-collection';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateCollection();

        $this->info('done creating product groups collection.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Product Group',
            'tabs' => [
                'main' => [
                    'display' => 'Hauptteil',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Title',
                                        'localizable' => false,
                                        'width' => 50,
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                    ],
                                    'handle' => 'title',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Handle',
                                        'localizable' => false,
                                        'width' => 50,
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                    ],
                                    'handle' => 'slug',
                                ],
                                [
                                    'field' => [
                                        'icon' => 'entries',
                                        'mode' => 'default',
                                        'type' => 'entries',
                                        'display' => 'Products',
                                        'localizable' => false,
                                        'collections' => ['products'],
                                    ],
                                    'handle' => 'products',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $blueprint = Blueprint::make('product_group')
            ->setContents($contents)
            ->setNamespace('collections.product_groups');

        $blueprint->save();
    }

    protected function createOrUpdateCollection()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $collection = Collection::make('product_groups');

        $collection
            ->title('Product Groups')
            ->dated(false)
            ->routes('/product-groups/{slug}')
            ->structure(null)
            ->sites($sites)
            ->searchIndex('product_groups')
            ->defaultPublishState(true)
            ->propagate(true);

        $collection->save();
    }
}
