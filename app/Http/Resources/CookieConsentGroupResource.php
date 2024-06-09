<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CookieConsentGroupResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description['text'],
            'can_be_deactivated' => $this->can_be_deactivated,
            'is_activated_by_default' => $this->is_activated_by_default,
        ];
    }
}
