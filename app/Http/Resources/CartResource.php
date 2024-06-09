<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,
            'shippingCosts' => $this->shippingCosts(),
            'skus' => CartSkuResource::collection($this->skus),
            'subtotalInclVat' => $this->subtotalInclVat(),
            'totalInclVat' => $this->totalInclVat(),
            'totalItems' => $this->totalItems(),
            'totalAllDiscounts' => $this->totalAllDiscounts(),
            'calculatedDiscountUsages' => $this->calculatedDiscountUsages(),
            'addressNeedsUpdating' => $this->validateAddressForCart()->fails(),
            'message' => $this->message,
            'payment_kind' => $this->payment_kind,
            'payment_kind_slug' => $this->payment_kind_slug,
            'shipping_same_as_invoice' => $this->shipping_same_as_invoice,
            'shipping_address' => new AddressResource($this->shipping_address),
            'invoice_address' => new AddressResource($this->invoice_address),
            'address_errors' => $this->addressesHaveBeenUpdated() ? $this->validateAddressForCart()->errors() : [],
        ];
    }
}
