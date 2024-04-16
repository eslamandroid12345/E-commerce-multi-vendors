<?php

namespace App\Http\Resources\V1\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryProductResource extends JsonResource
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
                    'image' => $this->firstImage->image,
                    'name' => $this->name,
                    'price' => $this->productFeatureItemPrice->price ?? 0.00,
                    'discount' => $this->productFeatureItemPrice->discount ?? 0.00,
                    'discounted_price' => $this->total_after_discount ?? 0,
                    'best_seller' => 1,
                    'seller_name' => $this->seller->name,
                    'has_prices' => $this->prices_count > 0 ? 1 : 0,
                    'has_features' => $this->features_count > 0 ? 1 : 0,

            ];
    }
}
