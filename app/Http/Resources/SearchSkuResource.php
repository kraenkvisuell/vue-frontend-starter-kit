<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchSkuResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->product->long_title.' '.$this->color?->title,
            'url' => route('products.show', [app()->getLocale(), $this->product->slug]).'#'.$this->color?->slug,
        ];
    }
}
