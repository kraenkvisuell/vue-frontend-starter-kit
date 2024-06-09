<?php

namespace App\Models;


use Statamic\Facades\Entry;
use App\Models\Traits\HasCdnMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class JobApplication extends Model implements HasMedia
{
    protected $guarded = [];

    use HasFactory;
    use InteractsWithMedia;
    use HasCdnMedia;

    public function job(): Attribute
    {
        return Attribute::make(
            get: fn() => Entry::find($this->job_id)
        );
    }
}
