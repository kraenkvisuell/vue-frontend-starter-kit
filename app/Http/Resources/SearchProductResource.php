<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchProductResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->long_title.'  // '.$this->tags_string,
            'url' => route('products.show', [app()->getLocale(), $this->slug]),
        ];
    }
}
