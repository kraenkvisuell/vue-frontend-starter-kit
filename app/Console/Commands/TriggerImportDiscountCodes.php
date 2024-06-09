<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportDiscountCodes;

class TriggerImportDiscountCodes extends Command
{
    protected $signature = 'shop:import-discount-codes';

    public function handle()
    {
        //DB::table('taxonomy_terms')->truncate();

        ImportDiscountCodes::dispatch();

        $this->info('done importing discount codes.');
    }
}
