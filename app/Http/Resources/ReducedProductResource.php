<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReducedProductResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tagsString' => $this->tags_string,
            'categorySlugs' => $this->product_categories->pluck('slug'),
            'group_title' => $this->product_group->title,
            'group_slug' => $this->product_group->slug,
            'reduced_title' => $this->reduced_title,
            'skus' => ReducedSkuResource::collection($this->skus->sortBy(function ($sku) {
                return count($sku->colors) ? $sku->colors[0]->sorter : 100000;
            })),
            'slug' => $this->slug,
            'tagSlugs' => $this->product_tags->pluck('slug'),
            'colorGroupIds' => $this->colorGroupIds(),
            'title' => $this->title,
            'size_string' => $this->size_string,
            'size_number' => $this->size_number,
            'url' => route('products.show', [app()->getLocale(), $this->slug]),
        ];
    }
}
