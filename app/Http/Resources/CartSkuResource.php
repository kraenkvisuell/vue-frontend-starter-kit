<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartSkuResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'color_title' => $this->color_title,
            'discount_price_incl_vat' => $this->discount_price_incl_vat,
            'has_discount_price' => $this->has_discount_price,
            'image' => $this->image,
            'price' => $this->price_incl_vat,
            'discounted_price' => $this->price_incl_vat,
            'product_title' => $this->product_title,
            'quantity' => $this->quantity,
            'tags_string' => $this->tags_string,
        ];
    }
}
