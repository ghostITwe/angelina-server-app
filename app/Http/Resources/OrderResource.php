<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date_order' => $this->updated_at,
            'delivery_address' => $this->delivery_address,
            'products' => CartItemResource::collection($this->products)
        ];
    }
}
