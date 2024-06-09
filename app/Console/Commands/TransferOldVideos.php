<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\TransferProductVideos;
use App\Jobs\TransferProductVideoLoops;

class TransferOldVideos extends Command
{
    protected $signature = 'shop:transfer-old-videos';

    public function handle()
    {
        //TransferProductVideoLoops::dispatch();
        TransferProductVideos::dispatch();

        $this->info('done transferring old videos.');
    }
}
