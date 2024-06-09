<?php

namespace App\Jobs\Merchants;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaveOrderXmlFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $order;

    protected $site;

    public function __construct(Order $order, string $site)
    {
        $this->order = $order;
        $this->site = $site;
    }

    public function handle()
    {

        $filename = 'zwei-order-' . $this->order->order_number . '.xml';

        $path = config('shop.xml_order_path');

        if ($path && !Str::endsWith($path, '/')) {
            $path .= '/';
        }

        $saved = Storage::disk('xml_orders')->put($path . $filename, $this->order->xmlView());
    }
}
