<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchTagResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => __('shop.shop').' / '.$this->firstCategory()['title'].' / '.$this->localized_title,
            'url' => route('shop.tag', [app()->getLocale(), $this->firstCategory()['slug'], $this->slug]),
        ];
    }
}
