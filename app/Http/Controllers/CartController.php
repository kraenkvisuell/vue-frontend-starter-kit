<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Items\CurrentCart;

class CartController
{
    public function store(CurrentCart $currentCart)
    {
        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
