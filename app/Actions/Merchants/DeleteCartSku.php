<?php

namespace App\Actions\Merchants;

use App\Models\BaseMerchantOrderSku;

class DeleteCartSku
{
    public function __invoke(int $cartSkuId): void
    {
        if ($cartSku = BaseMerchantOrderSku::find($cartSkuId)) {
            $cartSku->delete();
        }
    }
}
