<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Resources\Merchants\CartResource;
use App\Items\Merchants\CurrentCart;

class CartController
{
    public function show(CurrentCart $currentCart)
    {
        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
