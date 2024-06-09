<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\GlobalSet;

class RenameAll extends Command
{
    protected $signature = 'shop:rename-all';

    public function handle()
    {
        if (config('shop.rename_all')) {

            $set = GlobalSet::findByHandle('shop');
            $set = $set->in('default');
            $set->data(collect(config('shop.main_translations') ?: []));

            $set->save();

            $this->info('done renaming all.');
        } else {
            $this->comment('config not set for renaming.');
        }
    }
}
