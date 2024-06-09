<?php

namespace App\Http\Resources\Merchants;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CartSkuResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $merchant = Auth::guard('merchants')->user();

        return [
            'id' => $this->id,
            'color_title' => $this->color_title,
            'image' => $this->image,
            'price' => $this->price,
            'discounted_price' => $this->discountedPrice(),
            'is_preorder' => $this->original_sku?->is_preorder_per_site[$merchant->site],
            'product_title' => $this->product_title,
            'quantity' => $this->quantity,
            'slug' => $this->slug,
            'tags_string' => $this->tags_string,
        ];
    }
}
