<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompoundsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product_id'=> $this->product_id,
            'total_price'=> $this->total_price,
            'quantity'=> $this->quantity,
            'product'=> $this->products->name,
        ];
    }
}
