<?php

namespace App\Actions\Statamic;

use App\Models\Order;
use App\Notifications\YourOrderWasPlaced;
use Statamic\Actions\Action;

class ReNotifyCustomerOfOrder extends Action
{
    public function run($items, $values)
    {
        foreach ($items as $item) {
            $item->customer->notify(new YourOrderWasPlaced($item));
        }
    }

    public static function title()
    {
        return __('Bestellung erneut an Kunden senden');
    }

    public function visibleTo($item)
    {
        return $item instanceof Order;
    }
}
