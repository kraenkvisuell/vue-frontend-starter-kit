<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Site;
use Statamic\Facades\Taxonomy;

class CreateSpecialCharacteristicsTaxonomy extends Command
{
    protected $signature = 'shop:create-special-characteristics-taxonomy';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateTaxonomy();

        $this->info('done creating special characteristics taxonomy.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Special Characteristics',
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

        $blueprint = Blueprint::make('special_characteristic')
            ->setContents($contents)
            ->setNamespace('taxonomies.special_characteristics');

        $blueprint->save();
    }

    protected function createOrUpdateTaxonomy()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $taxonomy = Taxonomy::make('special_characteristics');

        $taxonomy
            ->title('Special Characteristics')
            ->sites($sites)
            ->searchIndex('special_characteristics');

        $taxonomy->save();
    }
}
