<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PeterColes\Countries\CountriesFacade;

class AddressResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'street' => $this->street,
            'additional_field' => $this->additional_field,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'country_iso' => $this->country_iso,
            'country' => CountriesFacade::countryName($this->country_iso, app()->getLocale()),
        ];
    }
}
