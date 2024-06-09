<?php

namespace App\Actions;

use App\Models\BaseOrderSku;

class UpdateCartSkuQuantity
{
    public function __invoke(int $cartSkuId, int $quantity): void
    {
        if ($cartSku = BaseOrderSku::find($cartSkuId)) {
            $cartSku->update([
                'quantity' => $quantity,
            ]);
        }
    }
}
