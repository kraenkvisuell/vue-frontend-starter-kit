<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchCategoryResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => __('shop.shop').' / '.$this->localized_title,
            'url' => route('shop.category', [app()->getLocale(), $this->slug]),
        ];
    }
}
