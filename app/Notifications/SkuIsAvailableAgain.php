<?php

namespace App\Notifications;

use App\Models\Sku;
use Statamic\Facades\GlobalSet;
use App\Service\GlobalsCacheService;
use Illuminate\Bus\Queueable;
use App\Models\AvailabilityReminder;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SkuIsAvailableAgain extends Notification
{
    use Queueable;

    public $sku;
    public $availabilityReminder;

    public function __construct(Sku $sku, AvailabilityReminder $availabilityReminder)
    {
        $this->sku = $sku;
        $this->availabilityReminder = $availabilityReminder;
        $this->queue = 'notifications';
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        app()->setLocale($this->availabilityReminder->locale);
        $subject = GlobalSet::findByHandle('mails')->in($this->availabilityReminder->site)
            ->get('availability_reminder_subject') ?: config('app.name') . ': ' . __('shop.article_available_again');

        return (new MailMessage)
            ->subject($subject)
            ->markdown('mail.sku-is-available-again', [
                'sku' => $this->sku,
                'availabilityReminder' => $this->availabilityReminder,
                'footer' => GlobalsCacheService::find('mails', 'mail_footer', 'text') ?: '<br><br>',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'sku_number' => $this->sku->slug,
            'customer_email' => $notifiable->email,
        ];
    }
}
