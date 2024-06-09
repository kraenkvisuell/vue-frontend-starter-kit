<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuProductResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tagsString' => $this->tags_string,
            'group_title' => $this->product_group->title,
            'group_slug' => $this->product_group->slug,
            'reduced_title' => $this->reduced_title,
            'slug' => $this->slug,
            'title' => $this->title,
            'url' => route('products.show', [app()->getLocale(), $this->slug]),
        ];
    }
}
