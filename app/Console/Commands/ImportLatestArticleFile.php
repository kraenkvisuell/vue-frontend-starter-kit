<?php

namespace App\Console\Commands;

use App\Jobs\ImportSkus;
use Illuminate\Console\Command;

class ImportLatestArticleFile extends Command
{
    protected $signature = 'shop:import-latest-article-file';

    public function handle()
    {
        ImportSkus::dispatch();

        $this->info('done importing latest article file.');
    }
}
