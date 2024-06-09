<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Site;
use Statamic\Facades\Taxonomy;

class CreateMaterialsTaxonomy extends Command
{
    protected $signature = 'shop:create-materials-taxonomy';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateTaxonomy();

        $this->info('done creating materials taxonomy.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Material',
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

        $blueprint = Blueprint::make('material')
            ->setContents($contents)
            ->setNamespace('taxonomies.materials');

        $blueprint->save();
    }

    protected function createOrUpdateTaxonomy()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $taxonomy = Taxonomy::make('materials');

        $taxonomy
            ->title('Materials')
            ->sites($sites)
            ->searchIndex('materials');

        $taxonomy->save();
    }
}
