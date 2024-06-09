<?php

namespace App\Console\Commands;

use App\Jobs\ImportSkuSftpImages;
use Illuminate\Console\Command;

class TriggerImportSkuSftpImages extends Command
{
    protected $signature = 'shop:import-sku-sftp-images';

    public function handle()
    {
        ImportSkuSftpImages::dispatch();

        $this->info('done triggering sku sftp images import.');
    }
}
