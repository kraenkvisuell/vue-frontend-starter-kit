<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetAndTest extends Command
{
    protected $signature = 'shop:reset-and-test';

    public function handle()
    {
        $this->call('horizon:clear');
        $this->call('shop:reset');
        $this->call('shop:import-latest-article-file');
        $this->call('horizon');
    }
}
