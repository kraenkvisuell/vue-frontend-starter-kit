<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\ClearAllShopCaches;

class TriggerClearAllShopCaches extends Command
{
    protected $signature = 'shop:clear-all-shop-caches';

    public function handle()
    {
        (new ClearAllShopCaches)();

        $this->info('done clearing all shop caches.');
    }
}
