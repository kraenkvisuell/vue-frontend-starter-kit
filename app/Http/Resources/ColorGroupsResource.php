<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorGroupsResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->getAttributeValue('localized_slug', 'en'),
            'title' => $this->getAttributeValue('localized_title'),
            'color' => $this->rgb ?: $this->getAttributeValue('localized_slug', 'en'),
            'categories' => $this->categories(),
            'tags' => $this->tags(),
            'productGroups' => $this->productGroups(),
        ];
    }
}
