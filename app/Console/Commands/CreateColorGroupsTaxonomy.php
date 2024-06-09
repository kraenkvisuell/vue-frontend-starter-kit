<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Site;
use Statamic\Facades\Taxonomy;

class CreateColorGroupsTaxonomy extends Command
{
    protected $signature = 'shop:create-color-groups-taxonomy';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateTaxonomy();

        $this->info('done creating color groups taxonomy.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Color Group',
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
                                        'width' => 50,
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

        $blueprint = Blueprint::make('color_group')
            ->setContents($contents)
            ->setNamespace('taxonomies.color_groups');

        $blueprint->save();
    }

    protected function createOrUpdateTaxonomy()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $taxonomy = Taxonomy::make('color_groups');

        $taxonomy
            ->title('Color Groups')
            ->sites($sites)
            ->searchIndex('color_groups');

        $taxonomy->save();
    }
}
