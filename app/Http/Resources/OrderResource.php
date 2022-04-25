<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'count' => $this->count,
            'user' => $this->user,
            'products' => ProductResource::collection($this->products)
        ];
    }
}
