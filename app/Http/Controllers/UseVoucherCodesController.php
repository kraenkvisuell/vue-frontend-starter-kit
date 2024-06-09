<?php

namespace App\Http\Controllers;

use App\Items\CurrentCart;
use App\Http\Resources\CartResource;
use App\Http\Requests\UseVoucherCodesRequest;
use App\Actions\AddDiscountsAndVouchersToCart;

class UseVoucherCodesController extends Controller
{
    public function store(
        UseVoucherCodesRequest $request,
        AddDiscountsAndVouchersToCart $addToCart,
        CurrentCart $currentCart
    )
    {
        $data = $request->validated();

        $cart = $currentCart();

        if (!$cart) {
            abort(404);
        }

        $addToCart(codes: $data['codes'], cart: $cart);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
