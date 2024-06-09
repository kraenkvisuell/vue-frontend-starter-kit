<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use PeterColes\Countries\CountriesFacade;

class Address extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->last_name,
        );
    }

    public function asHtml(): Attribute
    {
        $html = $this->full_name.'<br>';
        if ($this->company) {
            $html .= $this->company.'<br>';
        }
        $html .= $this->street.'<br>';
        if ($this->additional_field) {
            $html .= $this->additional_field.'<br>';
        }
        $html .= $this->postcode.' '.$this->city.'<br>';
        $html .= CountriesFacade::countryName($this->country_iso, app()->getLocale());

        return Attribute::make(
            get: fn () => $html,
        );
    }

    public function clear()
    {
        $this->update([
            'additional_field' => '',
            'city' => '',
            'company' => '',
            'country_iso' => config('shop.default_country_iso'),
            'email' => '',
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'postcode' => '',
            'street' => '',
        ]);
    }

    public function updateFromAddress(Address $otherAddress)
    {
        $this->update([
            'additional_field' => $otherAddress->additional_field,
            'city' => $otherAddress->city,
            'company' => $otherAddress->company,
            'country_iso' => $otherAddress->country_iso,
            'email' => $otherAddress->email,
            'first_name' => $otherAddress->first_name,
            'last_name' => $otherAddress->last_name,
            'phone' => $otherAddress->phone,
            'postcode' => $otherAddress->postcode,
            'street' => $otherAddress->street,
        ]);
    }
}
