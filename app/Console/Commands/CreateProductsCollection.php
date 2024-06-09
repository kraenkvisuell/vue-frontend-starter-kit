<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Site;

class CreateProductsCollection extends Command
{
    protected $signature = 'shop:create-products-collection';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateCollection();

        $this->info('done creating products collection.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Product',
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
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                    ],
                                    'handle' => 'title',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Dimensions',
                                        'localizable' => false,
                                        'validate' => [],
                                    ],
                                    'handle' => 'dimensions',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Volume',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 50,
                                    ],
                                    'handle' => 'volume',
                                ],
                                [
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Weight',
                                        'localizable' => false,
                                        'validate' => [],
                                        'width' => 50,
                                    ],
                                    'handle' => 'weight',
                                ],
                                [
                                    'field' => [
                                        'icon' => 'entries',
                                        'mode' => 'default',
                                        'type' => 'entries',
                                        'display' => 'SKUs',
                                        'localizable' => false,
                                        'collections' => ['skus'],
                                    ],
                                    'handle' => 'skus',
                                ],
                                [
                                    'field' => [
                                        'icon' => 'entries',
                                        'mode' => 'default',
                                        'type' => 'entries',
                                        'max_items' => 1,
                                        'display' => 'Product Group',
                                        'localizable' => false,
                                        'collections' => ['product_groups'],
                                    ],
                                    'handle' => 'product_group',
                                ],
                                [
                                    'field' => [
                                        'icon' => 'entries',
                                        'mode' => 'default',
                                        'type' => 'entries',
                                        'display' => 'Packagings',
                                        'localizable' => false,
                                        'collections' => ['packagings'],
                                    ],
                                    'handle' => 'packagings',
                                ],
                            ],
                        ],
                    ],
                ],
                'texts' => [
                    'display' => 'Texte',
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'field' => [
                                        'type' => 'bard',
                                        'display' => 'Description',
                                        'localizable' => true,
                                        'validate' => [],
                                        'buttons' => ['h3', 'h4', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'removeformat', 'anchor', 'table', 'horizontalrule'],
                                        'link_collections' => ['products'],
                                        'remove_empty_nodes' => 'trim',
                                    ],
                                    'handle' => 'description',
                                ],
                                [
                                    'field' => [
                                        'type' => 'bard',
                                        'display' => 'Features',
                                        'localizable' => true,
                                        'validate' => [],
                                        'buttons' => ['h3', 'h4', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'removeformat', 'anchor', 'table', 'horizontalrule'],
                                        'link_collections' => ['products'],
                                        'remove_empty_nodes' => 'trim',
                                    ],
                                    'handle' => 'features',
                                ],
                                [
                                    'field' => [
                                        'type' => 'bard',
                                        'display' => 'Material details',
                                        'localizable' => true,
                                        'validate' => [],
                                        'buttons' => ['h3', 'h4', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'removeformat', 'anchor', 'table', 'horizontalrule'],
                                        'link_collections' => ['products'],
                                        'remove_empty_nodes' => 'trim',
                                    ],
                                    'handle' => 'material_details',
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
                                        'type' => 'terms',
                                        'mode' => 'select',
                                        'display' => 'Product Categories',
                                        'localizable' => false,
                                        'taxonomies' => ['product_categories'],
                                    ],
                                    'handle' => 'product_categories',
                                ],
                                [
                                    'field' => [
                                        'type' => 'terms',
                                        'mode' => 'select',
                                        'display' => 'Materials',
                                        'localizable' => false,
                                        'taxonomies' => ['materials'],
                                    ],
                                    'handle' => 'materials',
                                ],
                                [
                                    'field' => [
                                        'type' => 'terms',
                                        'mode' => 'select',
                                        'display' => 'Special Characteristics',
                                        'localizable' => false,
                                        'taxonomies' => ['special_characteristics'],
                                    ],
                                    'handle' => 'special_characteristics',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $blueprint = Blueprint::make('product')
            ->setContents($contents)
            ->setNamespace('collections.products');

        $blueprint->save();
    }

    protected function createOrUpdateCollection()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $collection = Collection::make('products');

        $collection
            ->title('Products')
            ->dated(false)
            ->routes('/products/{slug}')
            ->structure(null)
            ->sites($sites)
            ->searchIndex('products')
            ->defaultPublishState(true)
            ->propagate(true);

        $collection->save();
    }
}
