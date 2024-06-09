<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantProductGroupResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'categories' => $this->categories(),
            'categories_string' => $this->categories_string,
            'tags' => $this->tags(),
            'products' => MerchantProductResource::collection($this->products),
        ];
    }
}
