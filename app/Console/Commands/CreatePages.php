<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Collection;
use Statamic\Facades\Site;

class CreatePages extends Command
{
    protected $signature = 'shop:create-pages';

    public function handle()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $collection = Collection::make('pages');

        $collection
            ->title('Seiten')
            ->dated(false)
            ->routes('/de/{slug}')
            ->structure(null)
            ->sites($sites)
            ->searchIndex('pages')
            ->defaultPublishState(true)
            ->propagate(true);

        $collection->save();

        $this->info('done creating pages.');
    }
}
