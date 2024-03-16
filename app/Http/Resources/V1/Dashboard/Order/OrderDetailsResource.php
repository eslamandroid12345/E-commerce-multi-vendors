<?php

namespace App\Http\Resources\V1\Dashboard\Order;

use App\Http\Resources\V1\Dashboard\Product\ProductFeatureItemDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
            'product_name' => $this->productFeatureItem->product->name,
            'product_imge' => $this->productFeatureItem->product->images->first()->image,
            'item_price' => $this->item_price,
            'quantity' => $this->quantity,
            'item_status' => $this->item_status,
            'seller' => $this->seller->name,
            'total_amount' => $this->totalAmount,
            'features' => ProductFeatureItemDetailResource::collection($this->productFeatureItem->productFeatureItemDetail),


        ];
    }
}
