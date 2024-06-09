<?php

namespace App\Actions\Statamic;

use App\Actions\ProcessOrderForSite;
use App\Models\Order;
use Statamic\Actions\Action;
use Statamic\Facades\Site;

class ReProcessOrderForSite extends Action
{
    public function run($items, $values)
    {
        foreach ($items as $item) {
            (new ProcessOrderForSite)($item, Site::selected()->handle());
        }
    }

    public static function title()
    {
        return __('Bestellung erneut an das WWS senden');
    }

    public function visibleTo($item)
    {
        return $item instanceof Order;
    }
}
