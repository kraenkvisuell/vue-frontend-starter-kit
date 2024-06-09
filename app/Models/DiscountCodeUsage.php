<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class DiscountCodeUsage extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;

    protected $guarded = [];

    public function discount_code(): BelongsTo
    {
        return $this->belongsTo(DiscountCode::class);
    }
}
