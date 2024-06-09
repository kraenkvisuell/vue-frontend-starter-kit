<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportSkuSftpVideos;

class TriggerImportSkuSftpVideos extends Command
{
    protected $signature = 'shop:import-sku-sftp-videos';

    public function handle()
    {
        ImportSkuSftpVideos::dispatch();

        $this->info('done triggering sku sftp videos import.');
    }
}
