<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kraenkvisuell\HasStatamicFields\Traits\HasStatamicFields;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class Color extends Model
{
    use HasFactory;
    use HasRunwayResource;
    use HasStatamicFields;
    use Prunable;
    use SoftDeletes;

    protected $guarded = [];

    public $casts = [
        'localized_title' => 'array',
    ];

    public $statamicTranslatable = [
        'localized_title',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

    public function color_groups()
    {
        return $this->belongsToMany(ColorGroup::class);
    }

    public function skus()
    {
        return $this->belongsToMany(Sku::class);
    }
}
