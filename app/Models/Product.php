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

class Product extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;
    use HasStatamicFields;
    use IsStatamicEditable;
    use Prunable;
    use SoftDeletes;
    use Searchable;
    use HasLocalizedSearchFields;

    public $casts = [
        'description' => 'array',
        'features' => 'array',
        'localized_slug' => 'array',
        'localized_title' => 'array',
        'material_details' => 'array',
        'og_description' => 'array',
        'og_title' => 'array',
        'seo_description' => 'array',
        'seo_text' => 'array',
        'seo_title' => 'array',
        'size_groups' => 'array',
        'topline' => 'array',
    ];

    public $statamicTranslatable = [
        'description',
        'features',
        'localized_slug',
        'localized_title',
        'material_details',
        'og_description',
        'og_title',
        'seo_description',
        'seo_text',
        'seo_title',
        'topline',
    ];

    public $statamicFields = [
        'description' => 'bard',
        'seo_text' => 'bard',
        'video_loops' => 'arrayOfMedia',
        'videos' => 'arrayOfMedia',
        'images' => 'arrayOfMedia',
        'og_image' => 'medium',
        'twitter_card_image' => 'medium',
    ];

    protected $guarded = [];

    protected $appends = [
        'integer_volume',
    ];

    public function searchableAs(): string
    {
        return 'products';
    }

    public function toSearchableArray()
    {
        $searchableArray = [
            'title' => $this->title,
            'product_group_title' => $this->product_group->title,
            'skus' => implode(' ', $this->skus->pluck('title')->toArray()),
        ];

        $localizedFields = $this->getLocalizedFields([
            'categories_string',
            'description',
            'features',
            'material_details',
            'seo_description',
            'tags_string',
            'topline',
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

    public function product_categories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function product_tags()
    {
        return $this->belongsToMany(ProductTag::class);
    }

    public function special_characteristics()
    {
        return $this->belongsToMany(SpecialCharacteristic::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function packagings()
    {
        return $this->belongsToMany(Packaging::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function colorGroupIds()
    {
        $ids = [];
        foreach ($this->skus as $sku) {
            foreach ($sku->color_groups as $colorGroup) {
                $ids[] = $colorGroup->id;
            }
        }

        return collect($ids)->unique()->all();
    }

    public function sizeString(): Attribute
    {
        $str = 's';

        if ($this->size_number >= config('shop.min_sizes.m')) {
            $str = 'm';
        }
        if ($this->size_number >= config('shop.min_sizes.l')) {
            $str = 'l';
        }

        return Attribute::make(
            get: fn() => $str,
        );
    }

    public function integerVolume(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => 0);
        }

        return Attribute::make(
            get: fn() => intval($this->volume) ?? 0,
        );
    }

    protected function categoriesString(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => '');
        }

        $categories = collect([]);
        $this->product_categories->each(function ($category) use (&$categories) {
            $categories->push(ucfirst($category->localized_title));
        });

        return Attribute::make(
            get: fn() => $this->product_categories ? $categories->unique()->implode(', ') : ''
        );
    }

    public function tagsString(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => '');
        }

        $tags = collect([]);
        $this->product_tags->each(function ($tag) use (&$tags) {
            $tags->push(ucfirst($tag->localized_title));
        });

        return Attribute::make(
            get: fn() => $this->product_tags ? $tags->unique()->implode(', ') : ''
        );
    }

    public function firstTagSlug(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => '');
        }

        return Attribute::make(
            get: fn() => $this->product_tags->count() ? $this->product_tags->first()->slug : 'none'
        );
    }

    public function prioTagSlugs(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => []);
        }

        return Attribute::make(
            get: fn() => config('shop.matching_tag_slugs')[$this->first_tag_slug] ?? []
        );
    }

    public function otherTagSlugs(): Attribute
    {
        if ($this->isInStatamic()) {
            return Attribute::make(get: fn() => []);
        }

        $slugs = config('shop.matching_tag_slugs')[$this->first_tag_slug] ?? [];

        return Attribute::make(
            get: fn() => ProductTag::whereNotIn('slug', $slugs)->pluck('slug')->toArray()
        );
    }

    public function reducedTitle(): Attribute
    {
        $lettersRemoved = $this->product_group?->letters_removed_from_product ?: 0;

        return Attribute::make(
            get: fn() => substr($this->title, $lettersRemoved),
        );
    }

    public function longTitle(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->product_group?->title . ' ' . $this->reduced_title,
        );
    }

    public function videoLoop(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->video_loops[0] ?? null,
        );
    }

    public function scopeOkForShop($builder)
    {
        return $builder->where('slug', '!=', 'div')->whereHas('skus', function ($b) {
            $b->okForShop();
        });
    }

    public function scopeOkForMerchants($builder)
    {
        return $builder->whereHas('skus', function ($b) {
            $b->okForMerchants();
        });
    }
}
