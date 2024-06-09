<?php

namespace App\Actions\Merchants;

use App\Models\MerchantOrder;
use App\Jobs\Merchants\SaveOrderXmlFile;
use App\Jobs\Merchants\SendInternalOrderMails;

class ProcessOrderForSite
{
    public function __invoke(MerchantOrder $order, string $site)
    {
        if ($site === 'suisse') {
            return SaveOrderXmlFile::dispatch($order, $site);
        }

        return SendInternalOrderMails::dispatch($order, $site);
    }
}
