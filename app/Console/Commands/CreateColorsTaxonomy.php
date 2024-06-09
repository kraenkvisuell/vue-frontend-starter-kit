<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Site;
use Statamic\Facades\Taxonomy;

class CreateColorsTaxonomy extends Command
{
    protected $signature = 'shop:create-colors-taxonomy';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateTaxonomy();

        $this->info('done creating colors taxonomy.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Color',
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
                                [
                                    'field' => [
                                        'icon' => 'color',
                                        'type' => 'color',
                                        'display' => 'Color value',
                                        'localizable' => false,
                                        'theme' => 'classic',
                                        'listable' => 'hidden',
                                        'color_modes' => ['rgba'],
                                        'lock_opacity' => true,
                                        'default_color_mode' => 'RGBA',
                                        'validate' => [],
                                        'width' => 50,
                                    ],
                                    'handle' => 'color_value',
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

        $blueprint = Blueprint::make('color')
            ->setContents($contents)
            ->setNamespace('taxonomies.colors');

        $blueprint->save();
    }

    protected function createOrUpdateTaxonomy()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $taxonomy = Taxonomy::make('colors');

        $taxonomy
            ->title('Colors')
            ->sites($sites)
            ->searchIndex('colors');

        $taxonomy->save();
    }
}
