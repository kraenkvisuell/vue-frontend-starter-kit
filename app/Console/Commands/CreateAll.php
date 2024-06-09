<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAll extends Command
{
    protected $signature = 'shop:create-all';

    public function handle()
    {
        $this->call('shop:create-global');
        $this->call('shop:create-pages');
        $this->call('shop:add-homepage');
        //         $this->call('shop:create-db-indexes');
        $this->call('shop:rename-all');
    }
}
