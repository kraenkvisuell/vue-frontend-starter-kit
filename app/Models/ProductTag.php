<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Models\Traits\HasLocalizedSearchFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kraenkvisuell\HasStatamicFields\Traits\HasStatamicFields;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class ProductTag extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;
    use HasStatamicFields;
    use Prunable;
    use SoftDeletes;
    use Searchable;
    use HasLocalizedSearchFields;

    protected $guarded = [];

    public $casts = [
        'localized_title' => 'array',
        'localized_slug' => 'array',
        'seo_title' => 'array',
        'og_title' => 'array',
        'seo_description' => 'array',
        'og_description' => 'array',
        'description' => 'array',
    ];

    public $statamicTranslatable = [
        'localized_title',
        'localized_slug',
        'seo_title',
        'og_title',
        'seo_description',
        'og_description',
        'description',
    ];

    public $statamicFields = [
        'og_image' => 'medium',
        'twitter_card_image' => 'medium',
    ];

    public function searchableAs(): string
    {
        return 'product_tags';
    }

    public function toSearchableArray()
    {
        $searchableArray = [
            'title' => $this->title,
        ];

        $localizedFields = $this->getLocalizedFields([
            'localized_title',
            'description',
        ]);

        return array_merge($searchableArray, $localizedFields);
    }

    public function getScoutKey(): mixed
    {
        return $this->slug;
    }

    public function getScoutKeyName(): mixed
    {
        return 'slug';
    }

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function categories()
    {
        $categories = collect([]);

        $this->products->each(function ($product) use (&$categories) {
            $product->product_categories->each(function ($tag) use (&$categories) {
                if (!$categories->firstWhere('slug', $tag->slug)) {
                    $categories->push([
                        'slug' => $tag->slug,
                        'title' => ucfirst($tag->localized_title),
                    ]);
                }
            });
        });

        return $categories->sortBy('title')->values()->all();
    }

    public function firstCategory()
    {
        if (count($this->categories())) {
            return $this->categories()[0];
        }

        return ProductCategory::first()->toArray();
    }
}
