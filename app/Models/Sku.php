<?php

namespace App\Models;

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

class Sku extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;
    use HasStatamicFields;
    use IsStatamicEditable;
    use Prunable;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['image', 'filtered_images'];

    protected $casts = [
        'discount_price_incl_vat_per_site' => 'array',
        'has_discount_price_per_site' => 'array',
        'is_available_per_site' => 'array',
        'is_preorder_per_site' => 'array',
        'merchant_price_per_site' => 'array',
        'price_incl_vat_per_site' => 'array',
        'vat_percentage_per_site' => 'array',
        'visible_for_merchants_per_site' => 'array',
        'visible_in_shop_per_site' => 'array',
        'merchant_availability_per_site' => 'array',
        'preorder_availability_per_site' => 'array',
        'in_merchant_promos' => 'array',
        'in_exports' => 'array',
        'fitting_skus' => 'array',
        'similar_skus' => 'array',
        'locations' => 'array',
        'location_prices' => 'array',
        'special_markers' => 'array',
    ];

    public $statamicFields = [
        'images' => 'arrayOfMedia',
        'videos' => 'arrayOfMedia',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function color_groups()
    {
        return $this->belongsToMany(ColorGroup::class);
    }

    public function isAvailableForSite($site)
    {
        return $this->is_available_per_site[$site] ?? false;
    }

    public function isPreorderForSite($site)
    {
        return $this->is_preorder_per_site[$site] ?? ($this->is_preorder_per_site['default'] ?? false);
    }

    public function preorderAvailabilityForSite($site)
    {
        if (!$this->isPreorderForSite($site)) {
            return '';
        }

        return $this->preorder_availability_per_site[$site] ?? ($this->preorder_availability_per_site['default'] ?? '');
    }

    public function visibleInShopForSite($site)
    {
        return $this->visible_in_shop_per_site[$site] ?? false;
    }

    public function visibleForMerchantsForSite($site)
    {
        return $this->visible_for_merchants_per_site[$site] ?? false;
    }

    public function priceInclVatForSite($site)
    {
        $price = $this->price_incl_vat_per_site[$site] ?? null;
        if ($price !== null) {
            return $price;
        }

        return $this->price_incl_vat_per_site['default'] ?? null;
    }

    public function discountPriceInclVatForSite($site)
    {
        $price = $this->discount_price_incl_vat_per_site[$site] ?? null;
        if ($price !== null) {
            return $price;
        }

        return $this->discount_price_incl_vat_per_site['default'] ?? null;
    }

    public function merchantPriceForSite($site)
    {
        $price = $this->merchant_price_per_site[$site] ?? null;
        if ($price !== null) {
            return $price;
        }

        return $this->merchant_price_per_site['default'] ?? null;
    }

    public function vatPercentageForSite($site)
    {
        $price = $this->vat_percentage_per_site[$site] ?? null;
        if ($price !== null) {
            return $price;
        }

        return $this->vat_percentage_per_site['default'] ?? null;
    }

    protected function filteredImages(): Attribute
    {
        return Attribute::make(
            get: fn() => collect($this->images)->unique('perspective')->all(),
        );
    }

    protected function priceInclVat(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->price_incl_vat_per_site[config('app.current_site')],
        );
    }

    protected function discountPriceInclVat(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->discount_price_incl_vat_per_site[config('app.current_site')],
        );
    }

    protected function hasDiscountPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => (bool)$this->discount_price_incl_vat_per_site[config('app.current_site')],
        );
    }

    protected function merchantPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->merchant_price_per_site[config('app.current_site')],
        );
    }

    protected function vatPercentage(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->vat_percentage_per_site[config('app.current_site')],
        );
    }

    protected function color(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->colors->count() ? $this->colors->first() : '',
        );
    }

    protected function colorGroup(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->color_groups->count() ? $this->color_groups->first() : new ColorGroup(),
        );
    }

    protected function longTitle(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->product?->long_title . ' / ' . $this->color->title,
        );
    }

    protected function minMaxSizes(): Attribute
    {
        $minSize = 0;
        $maxSize = 5;

        if ($this->product->size_number >= config('shop.min_sizes.m')) {
            $minSize = config('shop.min_sizes.m');
            $maxSize = config('shop.min_sizes.l') - 1;
        }

        if ($this->product->size_number >= config('shop.min_sizes.l')) {
            $minSize = config('shop.min_sizes.l');
            $maxSize = 999999;
        }

        return Attribute::make(
            get: fn() => [$minSize, $maxSize],
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->images[0] ?? null,
        );
    }

    public function scopeSimilarTo($builder, $id)
    {
        $sku = $this->where('id', $id)->with([
            'product' => function ($b) {
                $b->with([
                    'product_tags',
                ]);
            },
            'color_groups' => function ($b) {
                $b->select(['color_groups.id']);
            },
        ])->first();

        return $builder->where('id', '!=', $id)
            ->okForShop()
            ->withWhereHas('color_groups', function ($b) use ($sku) {
                $b->select(['color_groups.id'])->whereIn('color_groups.id', [$sku->color_group?->id]);
            })
            ->withWhereHas('product', function ($b) use ($sku) {
                $b->where('id', '!=', $sku->product->id)
                    ->okForShop()
                    ->where('gender', $sku->product->gender)
                    ->withWhereHas('product_tags', function ($b) use ($sku) {
                        $b->whereIn('product_tags.id', $sku->product->product_tags->pluck('id'));
                    })->whereBetween('size_number', $sku->min_max_sizes);
            });
    }

    public function scopePrioMatching($builder, $id)
    {
        $sku = $this->where('id', $id)->with([
            'product' => function ($b) {
                $b->with([
                    'product_tags',
                ]);
            },
            'colors' => function ($b) {
                $b->select(['colors.id', 'colors.slug']);
            },
        ])->first();

        return $builder->where('id', '!=', $id)
            ->okForShop()
            ->withWhereHas('colors', function ($b) use ($sku) {
                $b->select(['colors.id', 'colors.slug'])->whereIn('colors.id', [$sku->color?->id]);
            })
            ->withWhereHas('product', function ($b) use ($sku) {
                $b->where('id', '!=', $sku->product->id)
                    ->okForShop()
                    //->where('gender', $sku->product->gender)
                    ->withWhereHas('product_tags', function ($b) use ($sku) {
                        $b->whereIn('product_tags.slug', $sku->product->prio_tag_slugs);
                    })
                    ->whereDoesntHave('product_tags', function ($b) use ($sku) {
                        $b->where('product_tags.slug', $sku->product->first_tag_slug);
                    });
            });
    }

    public function scopeOtherMatching($builder, $id)
    {
        $sku = $this->where('id', $id)->with([
            'product' => function ($b) {
                $b->with([
                    'product_tags',
                ]);
            },
            'colors' => function ($b) {
                $b->select(['colors.id', 'colors.slug']);
            },
        ])->first();

        return $builder->where('id', '!=', $id)
            ->okForShop()
            ->withWhereHas('colors', function ($b) use ($sku) {
                $b->select(['colors.id', 'colors.slug'])->whereIn('colors.id', [$sku->color?->id]);
            })
            ->withWhereHas('product', function ($b) use ($sku) {
                $b->where('id', '!=', $sku->product->id)
                    ->okForShop()
                    ->where('gender', $sku->product->gender)
                    ->withWhereHas('product_tags', function ($b) use ($sku) {
                        $b->whereIn('product_tags.slug', $sku->product->other_tag_slugs);
                    })
                    ->whereDoesntHave('product_tags', function ($b) use ($sku) {
                        $b->where('product_tags.slug', $sku->product->first_tag_slug);
                    });
            });
    }

    public function scopeOkForShop($builder)
    {
        return $builder->where('visible_in_shop_per_site->' . config('app.current_site'), true);
    }

    public function scopeOkForMerchants($builder)
    {
        return $builder->where('visible_for_merchants_per_site->' . config('app.current_site'), true);
    }
}
