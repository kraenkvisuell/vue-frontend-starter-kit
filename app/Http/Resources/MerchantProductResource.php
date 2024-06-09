<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantProductResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categories_string' => $this->categories_string,
            'category_slugs' => $this->product_categories->pluck('slug'),
            'contains_magnets' => $this->contains_magnets,
            'description' => $this->description,
            'dimensions' => $this->dimensions,
            'features' => $this->features,
            'group_title' => $this->product_group->title,
            'images' => $this->images,
            'integer_volume' => $this->integer_volume,
            'laptop_dimension' => $this->laptop_dimension,
            'material_details' => $this->material_details,
            'reduced_title' => $this->reduced_title,
            'slug' => $this->slug,
            'tags_string' => $this->tags_string,
            'title' => $this->title,
            'video' => $this->video_loop,
            'volume' => $this->volume,
            'weight' => $this->weight,

            'skus' => MerchantSkuResource::collection($this->skus->sortBy(function ($sku) {
                return count($sku->colors) ? $sku->colors[0]->sorter : 100000;
            })),
        ];
    }
}
