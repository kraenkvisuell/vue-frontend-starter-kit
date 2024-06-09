<?php

namespace App\Notifications;

use App\Models\Order;
use Statamic\Facades\GlobalSet;
use App\Service\EntryCacheService;
use App\Service\GlobalsCacheService;
use App\Service\NumberService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YourOrderWasPlaced extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = GlobalSet::findByHandle('mails')->in($this->order->site)->get('order_confirmation_subject')
            ?: config('app.name') . ': ' . __('shop.thanks_for_your_order');

        return (new MailMessage)
            ->subject($subject)
            ->markdown('mail.your-order-was-placed', [
                'order' => $this->order,
                'intro' => $this->intro(),
                'outro' => $this->outro(),
                'revocationExplanation' => GlobalsCacheService::find('legal', 'revocation_explanation', 'text') ?: '',
                'footer' => GlobalsCacheService::find('mails', 'mail_footer', 'text') ?: '<br><br>',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'customer_email' => $notifiable->email,
        ];
    }

    protected function outro(): string
    {
        $template = EntryCacheService::entryBySlug(slug: 'order_confirmation', collection: 'mail_templates');

        $outro = $template['outro'] ? $template['outro']['text'] : '';

        if ($this->order->payment_kind_slug === 'prepayment') {
            $outro .= GlobalsCacheService::find('mails', 'outro_prepayment', 'text') ?: '';
        } elseif ($this->order->payment_kind_slug === 'stripe') {
            $outro .= GlobalsCacheService::find('mails', 'outro_stripe', 'text') ?: '';
        }

        $outro = str_replace('[kunde]', $this->order->customer?->full_name, $outro);
        $outro = str_replace('[bestellnummer]', $this->order->order_number, $outro);
        $outro = str_replace(
            '[bestellsumme]',
            NumberService::formattedFromCents($this->order->totalInclVat()) . '&nbsp;' . config('shop.currency_sign'),
            $outro
        );
        $outro = str_replace(
            '[bankdaten]',
            nl2br(GlobalsCacheService::find('shop', 'bank_data') ?: ''),
            $outro
        );

        return $outro;
    }

    protected function intro(): string
    {
        $template = EntryCacheService::entryBySlug(slug: 'order_confirmation', collection: 'mail_templates');

        $intro = $template['intro'] ? $template['intro']['text'] : '';
        $intro = str_replace('[kunde]', $this->order->customer?->full_name, $intro);

        return $intro;
    }
}
