<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Reset extends Command
{
    protected $signature = 'shop:reset';

    public function handle()
    {
        $this->call('migrate:fresh');
        $this->call('shop:create-first-user');
        $this->call('shop:create-all');
    }
}
