<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckAvailabilityReminders;

class TriggerCheckAvailabilityReminders extends Command
{
    protected $signature = 'shop:check-availability-reminders';

    public function handle()
    {
        CheckAvailabilityReminders::dispatch();

        $this->info('done triggering availability reminder checks.');
    }
}
