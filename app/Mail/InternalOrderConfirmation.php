<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Statamic\Facades\GlobalSet;

class InternalOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $site;

    public function __construct(Order $order, string $site)
    {
        $this->order = $order;
        $this->site = $site;
    }

    public function build()
    {

        $subject = GlobalSet::findByHandle('mails')->in($this->site)->get('internal_order_subject');
        $subject = str_replace('{order-number}', $this->order->order_number, $subject);

        if (
            $this->order->totalInclVat() == 0
            &&
            (
                $this->order->voucher_usages->count()
                || $this->order->cryptcode
                || $this->order->promocode
                || $this->order->onetime_code
            )
        ) {
            $subject .= ' BEZAHLT';
        }

        $subject .= ' (INTERN)';

        $mail = $this->view(['text' => 'mail.internal-order-mail'])
            ->subject($subject)
            ->with([
                'order' => $this->order,
            ]);

        //        foreach ($this->order->products as $product) {
        //            if ($product->is_voucher && $product->voucher) {
        //                $mail->attachData($product->voucher->generatePdf()->output(), 'zwei-gutschein-'.time().'.pdf', [
        //                    'mime' => 'application/pdf',
        //                ]);
        //            }
        //        }

        return $mail;
    }
}
