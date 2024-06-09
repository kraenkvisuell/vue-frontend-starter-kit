<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Models\Traits\HasLocalizedSearchFields;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kraenkvisuell\HasStatamicFields\Traits\HasStatamicFields;
use Kraenkvisuell\HasStatamicFields\Traits\IsStatamicEditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use StatamicRadPack\Runway\Traits\HasRunwayResource;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class ProductGroup extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRelationships;
    use HasRunwayResource;
    use HasStatamicFields;
    use IsStatamicEditable;
    use Prunable;
    use SoftDeletes;
    use Searchable;
    use HasLocalizedSearchFields;

    protected $guarded = [];

    public $casts = [
        'localized_title' => 'array',
        'localized_slug' => 'array',
        'description' => 'array',
        'seo_title' => 'array',
        'og_title' => 'array',
        'seo_description' => 'array',
        'og_description' => 'array',
    ];

    public $statamicTranslatable = [
        'localized_title',
        'localized_slug',
        'description',
        'seo_title',
        'og_title',
        'seo_description',
        'og_description',
    ];

    public $statamicFields = [
        'description' => 'bard',
        'og_image' => 'medium',
        'twitter_card_image' => 'medium',
    ];

    public function searchableAs(): string
    {
        return 'product_groups';
    }

    public function toSearchableArray()
    {
        $searchableArray = [
            'title' => $this->title,
            'products' => implode(' ', $this->products->pluck('title')->toArray()),
        ];

        $localizedFields = $this->getLocalizedFields([
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
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        $categories = [];
        foreach ($this->products as $product) {
            foreach ($product->product_categories as $category) {
                $categories[] = [
                    'id' => $category->id,
                    'slug' => $category->slug,
                ];
            }
        }

        return collect($categories)->unique()->all();
    }

    protected function categoriesString(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => '');
        }

        $categories = collect([]);

        foreach ($this->products as $product) {
            foreach ($product->product_categories as $category) {
                $categories->push(ucfirst($category->localized_title));
            }
        }

        return Attribute::make(
            get: fn() => $categories->count() ? $categories->unique()->implode(', ') : ''
        );
    }

    public function tags()
    {
        $tags = [];
        foreach ($this->products as $product) {
            foreach ($product->product_tags as $tag) {
                $tags[] = [
                    'id' => $tag->id,
                    'slug' => $tag->slug,
                ];
            }
        }

        return collect($tags)->unique()->all();
    }

    public function scopeForMerchants($builder)
    {
        return $builder->withWhereHas('products', function ($b) {

        });
    }
}
