<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categories_string' => $this->categories_string,
            'description' => $this->description,
            'dimensions' => $this->dimensions,
            'features' => $this->features,
            'fitting_products' => [],
            'group_title' => $this->product_group->title,
            'images' => $this->images,
            'laptop_dimensions' => $this->laptop_dimensions,
            'material_details' => $this->material_details,
            'og_description' => $this->og_description,
            'og_image' => $this->og_image,
            'og_title' => $this->og_title,
            'reduced_title' => $this->reduced_title,
            'seo_description' => $this->seo_description,
            'seo_text' => $this->seo_text,
            'seo_title' => $this->seo_title,
            'similar_products' => [],
            'slug' => $this->slug,
            'tags_string' => $this->tags_string,
            'title' => $this->title,
            'topline' => $this->topline,
            'twitter_card_image' => $this->twitter_card_image,
            'video' => $this->video_loop,
            'volume' => $this->volume,
            'weight' => $this->weight,

            'skus' => ReducedSkuResource::collection($this->skus->sortBy(function ($sku) {
                return count($sku->colors) ? $sku->colors[0]->sorter : 100000;
            })),
        ];
    }
}
