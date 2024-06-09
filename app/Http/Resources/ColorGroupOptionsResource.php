<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorGroupOptionsResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'label' => $this->getAttributeValue('localized_title'),
            'value' => $this->slug,
        ];
    }
}
