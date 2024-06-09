<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductGroupsResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'seo_title' => $this->seo_title,
            'og_title' => $this->og_title,
            'seo_description' => $this->seo_description,
            'og_description' => $this->og_description,
            'og_image' => $this->og_image,
            'twitter_card_image' => $this->twitter_card_image,
            'categories' => $this->categories(),
            'tags' => $this->tags(),
        ];
    }
}
