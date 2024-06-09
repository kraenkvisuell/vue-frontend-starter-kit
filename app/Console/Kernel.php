<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily();

        $schedule->command('shop:import-sku-sftp-images')->hourlyAt(37)->graceTimeInMinutes(15);

        $schedule->command('shop:import-sku-sftp-videos')->hourlyAt(17)->graceTimeInMinutes(15);

        $schedule->command('shop:import-sku-sftp-merchant-videos')->hourlyAt(57)->graceTimeInMinutes(15);

        $schedule->command('shop:import-latest-article-file')->everyFifteenMinutes()->graceTimeInMinutes(15);

        $schedule->command('shop:import-discount-codes')->everyThirtyMinutes()->graceTimeInMinutes(15);

        $schedule->command('shop:check-availability-reminders')->hourlyAt(23)->graceTimeInMinutes(15);
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
