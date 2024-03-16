<?php

namespace App\Http\Resources\V1\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
        'name' => $this->name,
        'translations' => $this->all_translations,
        'price' => $this->productFeatureItemPrice ? $this->productFeatureItemPrice->price : 0,
        'product_code' => $this->product_code,
        'tags' => $this->tags,
        'discount' => 0,
        'category' => $this->category->name,
        'sub_category' => $this->sub_category->name,
        'brand' => $this->brand->name,
        'seller' => $this->seller->name,
        'in_stock_items' => $this->quantity_count,
        'activation' => $this->is_active,
        'has_prices' => $this->prices_count > 0 ? 1 : 0,
        'has_features' => $this->features_count > 0 ? 1 : 0,
        'images' =>   ProductImageResource::collection($this->images),
        ];
    }
}

