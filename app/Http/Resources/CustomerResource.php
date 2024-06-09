<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'shipping_same_as_invoice' => $this->shipping_same_as_invoice,
            'shipping_address' => new AddressResource($this->shipping_address),
            'invoice_address' => new AddressResource($this->invoice_address),
        ];
    }
}
