<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportSkuSftpMerchantVideos;

class TriggerImportSkuSftpMerchantVideos extends Command
{
    protected $signature = 'shop:import-sku-sftp-merchant-videos';

    public function handle()
    {
        ImportSkuSftpMerchantVideos::dispatch();

        $this->info('done triggering sku sftp merchant videos import.');
    }
}
