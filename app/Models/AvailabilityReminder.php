<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilityReminder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function close()
    {
        $this->update(['notified_at' => now()]);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNull('notified_at');
    }
}
