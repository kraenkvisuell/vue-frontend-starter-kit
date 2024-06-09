<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantSkuResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'availability' => $this->merchant_availability_per_site[config('app.current_site')] ?? 'bogus',
            'color_group_slug' => $this->color_group?->slug ?: '',
            'colors' => ColorResource::collection($this->colors),
            'id' => $this->id,
            'image' => $this->image,
            'is_new' => (bool) $this->is_new,
            'is_preorder' => $this->is_preorder_per_site[config('app.current_site')] ?? false,
            'preorder_availability' => $this->preorder_availability_per_site[config('app.current_site')] ?? '',
            'price' => $this->merchant_price,
            'selling_price' => $this->price_incl_vat,
            'product_id' => $this->product_id,
            'slug' => $this->slug,
            'title' => $this->title,
        ];
    }
}
