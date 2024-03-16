<?php

namespace App\Http\Resources\V1\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
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
             'seller_name' => $this->seller->name,
             'total_orders' => $this->count_orders,
             'in_stock' => $this->quantity_count,
             'total_visitors' => 1,
             'new_orders' => $this->count_new_orders,
             'name' => $this->name,
             'tags' => $this->tags,
            'translations' => $this->all_translations,
             'price' => $this->productFeatureItemPrice ? $this->productFeatureItemPrice->price : 0,
             'product_code' => $this->product_code,
             'category' => $this->category->name,
             'sub_category' => $this->sub_category->name,
             'images' =>   ProductImageResource::collection($this->images),
             'orders' => ProductOrdersResource::collection($this->orderDetails)
        ];
    }
}
