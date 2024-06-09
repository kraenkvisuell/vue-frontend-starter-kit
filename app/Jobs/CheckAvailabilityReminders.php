<?php

namespace App\Jobs;

use App\Models\Sku;
use Illuminate\Bus\Queueable;
use App\Models\AvailabilityReminder;
use App\Notifications\SkuIsAvailableAgain;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class CheckAvailabilityReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    public function handle()
    {
        $site = config('app.current_site');

        $notifyableSkus = Sku::where(['is_available_per_site->' . $site => true])->get();

        foreach ($notifyableSkus as $sku) {

            $availabilityReminders = AvailabilityReminder::open()
                ->where([
                    'sku_number' => $sku->slug,
                    'site' => $site,
                ])
                ->get();


            foreach ($availabilityReminders as $availabilityReminder) {
                Notification::route('mail', $availabilityReminder->email)
                    ->notify(new SkuIsAvailableAgain($sku, $availabilityReminder));

                $availabilityReminder->close();
            }
        }
    }
}
