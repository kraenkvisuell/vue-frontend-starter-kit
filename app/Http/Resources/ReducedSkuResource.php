<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReducedSkuResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cents' => intval((($this->price_incl_vat / 100) - (intval($this->price_incl_vat / 100))) * 100),
            'colorGroups' => $this->color_groups->pluck('id'),
            'colors' => ColorResource::collection($this->colors),
            'dollars' => intval($this->price_incl_vat / 100),
            'image' => $this->image,
            'images' => $this->images,
            'is_available' => $this->isAvailableForSite(config('app.current_site')),
            'is_new' => $this->is_new,
            'price' => $this->price_incl_vat,
            'slug' => $this->slug,
            'title' => $this->title,
            'videos' => $this->videos,
        ];
    }
}
