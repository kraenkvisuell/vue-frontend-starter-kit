<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => $this->image,
            'colors' => ColorResource::collection($this->colors),
            'colorGroups' => $this->color_groups->pluck('id'),
            'price' => $this->price_incl_vat,
            'dollars' => intval($this->price_incl_vat / 100),
            'cents' => intval((($this->price_incl_vat / 100) - (intval($this->price_incl_vat / 100))) * 100),
            'product' => new SkuProductResource($this->product),
        ];
    }
}
