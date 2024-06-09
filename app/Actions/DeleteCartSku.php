<?php

namespace App\Actions;

use App\Models\BaseOrderSku;

class DeleteCartSku
{
    public function __invoke(int $cartSkuId): void
    {
        if ($cartSku = BaseOrderSku::find($cartSkuId)) {
            $cartSku->delete();
        }
    }
}
