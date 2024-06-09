<?php

namespace App\Jobs\Merchants;

use App\Models\MerchantOrder;
use App\Mail\Merchants\InternalOrderConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Statamic\Facades\GlobalSet;

class SendInternalOrderMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $order;

    protected $site;

    public function __construct(MerchantOrder $order, string $site)
    {
        $this->order = $order;
        $this->site = $site;
    }

    public function handle()
    {
        $recipients = GlobalSet::findByHandle('mails')->in($this->site)->get('internal_order_recipients');
        $recipients = collect(array_map('trim', explode(',', $recipients)))
            ->filter(fn($recipient) => filter_var($recipient, FILTER_VALIDATE_EMAIL));

        foreach ($recipients as $recipient) {
            Mail::to($recipient)
                ->send(new InternalOrderConfirmation($this->order, $this->site));
        }
    }
}
