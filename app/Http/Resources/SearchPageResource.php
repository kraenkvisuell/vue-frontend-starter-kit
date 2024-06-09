<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchPageResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->resource->title,
            'url' => route('pages.show', [config('app.locale'), $this->resource->slug]),
        ];
    }
}
