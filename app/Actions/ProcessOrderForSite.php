<?php

namespace App\Actions;

use App\Jobs\SaveOrderXmlFile;
use App\Jobs\SendInternalOrderMails;
use App\Models\Order;

class ProcessOrderForSite
{
    public function __invoke(Order $order, string $site)
    {
        if ($site === 'suisse') {
            return SaveOrderXmlFile::dispatch($order, $site);
        }

        return SendInternalOrderMails::dispatch($order, $site);
    }
}
