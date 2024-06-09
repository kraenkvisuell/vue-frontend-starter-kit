<?php

namespace App\Http\Controllers;

use App\Actions\UpdateCartSkuQuantity;
use App\Http\Resources\CartResource;
use App\Items\CurrentCart;

class CartSkuQuantityController
{
    public function update(UpdateCartSkuQuantity $update, CurrentCart $currentCart)
    {
        $update(cartSkuId: request()->id, quantity: request()->quantity);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
