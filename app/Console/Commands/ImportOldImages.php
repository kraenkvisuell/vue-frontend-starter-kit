<?php

namespace App\Console\Commands;

use App\Jobs\ImportProductImages;
use App\Jobs\ImportProductVideoLoops;
use App\Jobs\ImportProductVideos;
use App\Jobs\ImportSkuImages;
use Illuminate\Console\Command;

class ImportOldImages extends Command
{
    protected $signature = 'shop:import-old-images';

    public function handle()
    {
        ImportSkuImages::dispatch();
        ImportProductImages::dispatch();
        ImportProductVideos::dispatch();
        ImportProductVideoLoops::dispatch();

        $this->info('done importing old images.');
    }
}
