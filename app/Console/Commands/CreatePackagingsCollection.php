<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Site;

class CreatePackagingsCollection extends Command
{
    protected $signature = 'shop:create-packagings-collection';

    public function handle()
    {
        $this->createOrUpdateBlueprint();

        $this->createOrUpdateCollection();

        $this->info('done creating packagings collection.');
    }

    protected function createOrUpdateBlueprint()
    {
        $contents = [
            'title' => 'Packaging',
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
                                        'validate' => ['required', 'unique_entry_value:{collection},{id},{site}'],
                                    ],
                                    'handle' => 'title',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $blueprint = Blueprint::make('packaging')
            ->setContents($contents)
            ->setNamespace('collections.packagings');

        $blueprint->save();
    }

    protected function createOrUpdateCollection()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $collection = Collection::make('packagings');

        $collection
            ->title('Packagings')
            ->dated(false)
            ->routes('/packagings/{slug}')
            ->structure(null)
            ->sites($sites)
            ->searchIndex('packagings')
            ->defaultPublishState(true)
            ->propagate(true);

        $collection->save();
    }
}
