<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'active_child_number' => $this->active_child_number,
            'can_order_for_children' => $this->can_order_for_children,
            'can_pay_online' => $this->can_pay_online,
            'can_see_prices' => $this->can_see_prices,
            'company_name' => $this->company_name,
            'discount_percentage' => $this->discount_percentage,
            'email' => $this->email,
            'free_limit' => $this->free_limit,
            'number' => $this->number,

        ];
    }
}
