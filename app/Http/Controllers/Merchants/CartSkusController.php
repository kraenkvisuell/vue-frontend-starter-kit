<?php

namespace App\Http\Controllers\Merchants;

use App\Actions\Merchants\DeleteCartSku;
use App\Http\Resources\Merchants\CartResource;
use App\Items\Merchants\CurrentCart;

class CartSkusController
{
    public function delete(DeleteCartSku $delete, CurrentCart $currentCart)
    {
        $delete(cartSkuId: request()->id);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
