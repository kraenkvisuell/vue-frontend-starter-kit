<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kraenkvisuell\HasStatamicFields\Traits\HasStatamicFields;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class SpecialCharacteristic extends Model
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

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
