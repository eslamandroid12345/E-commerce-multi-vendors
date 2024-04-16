<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Seller;

use App\Http\Resources\V1\Dashboard\Product\ProductImageResource;
use App\Http\Resources\V1\Dashboard\Product\SellerProductsShowResource;
use Illuminate\Http\Request;
use App\Http\Resources\V1\Dashboard\Product\SubCategoryProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
                    'phone' => $this->phone,
                    'store_name' => $this->store_name,
                    'email' => $this->email,
                    'activation' => $this->is_active,
                    'ItemInStock' => 0,
                    'total_order' => 0,
                    'total_product' => $this->products->count(),
                    'total_visitors' => 0,
                    'total_sales' => 0,
                    'total_revenue' => 0,
                    'image' => url($this->image),
                    'chart' => $this->category,
                    'products' => SellerProductsShowResource::collection($this->products),

        ];
    }
}
