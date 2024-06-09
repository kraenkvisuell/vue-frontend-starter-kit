<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Site;
use Statamic\Facades\Taxonomy;

class CreateProductCategoriesTaxonomy extends Command
{
    protected $signature = 'shop:create-product-categories-taxonomy';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateTaxonomy();

        $this->info('done creating product categories taxonomy.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Product Categories',
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
                                        'localizable' => true,
                                    ],
                                    'handle' => 'title',
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
                                        'localizable' => true,
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                    ],
                                    'handle' => 'slug',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $blueprint = Blueprint::make('product_category')
            ->setContents($contents)
            ->setNamespace('taxonomies.product_categories');

        $blueprint->save();
    }

    protected function createOrUpdateTaxonomy()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $taxonomy = Taxonomy::make('product_categories');

        $taxonomy
            ->title('Product Categories')
            ->sites($sites)
            ->searchIndex('product_categories');

        $taxonomy->save();
    }
}
