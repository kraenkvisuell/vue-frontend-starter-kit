<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kraenkvisuell\HasStatamicFields\Traits\HasStatamicFields;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class ColorGroup extends Model
{
    use HasFactory;
    use HasRunwayResource;
    use HasStatamicFields;
    use Prunable;
    use SoftDeletes;

    protected $guarded = [];

    public $casts = [
        'localized_title' => 'array',
        'localized_slug' => 'array',
    ];

    public $statamicTranslatable = [
        'localized_title',
        'localized_slug',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

    public function skus()
    {
        return $this->belongsToMany(Sku::class);
    }

    public function categories()
    {
        $categories = [];
        foreach ($this->skus as $sku) {
            foreach ($sku->product->product_categories as $category) {
                $categories[] = [
                    'id' => $category->id,
                    'slug' => $category->slug,
                ];
            }
        }

        return collect($categories)->unique()->all();
    }

    public function tags()
    {
        $tags = [];
        foreach ($this->skus as $sku) {
            foreach ($sku->product->product_tags as $tag) {
                $tags[] = [
                    'id' => $tag->id,
                    'slug' => $tag->slug,
                ];
            }
        }

        return collect($tags)->unique()->all();
    }

    public function productGroups()
    {
        $productGroups = [];
        foreach ($this->skus as $sku) {
            $productGroups[] = [
                'id' => $sku->product->product_group->id,
                'slug' => $sku->product->product_group->slug,
            ];
        }

        return collect($productGroups)->unique()->all();
    }
}
