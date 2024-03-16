<?php

namespace App\Http\Resources\V1\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFeatureItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'product_price' => $this->product_price,
            'price' => $this->price,
            'discount' => $this->discount,
            'quantity' => $this->quantity,
            'features' => ProductFeatureItemDetailResource::collection($this->productFeatureItemDetail),
        ];
    }
}
