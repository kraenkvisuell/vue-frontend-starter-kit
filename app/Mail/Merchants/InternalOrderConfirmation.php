<?php

namespace App\Mail\Merchants;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\MerchantOrder;
use Illuminate\Queue\SerializesModels;
use Statamic\Facades\GlobalSet;

class InternalOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $site;

    public function __construct(MerchantOrder $order, string $site)
    {
        $this->order = $order;
        $this->site = $site;
    }

    public function build()
    {

        $subject = GlobalSet::findByHandle('merchants')->in($this->site)->get('internal_order_subject');
        $subject = str_replace('{order-number}', $this->order->order_number, $subject);

        $subject .= ' (INTERN)';

        $mail = $this->view(['text' => 'mail.internal-merchant-order-mail'])
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
