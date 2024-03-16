<?php

namespace App\Http\Resources\V1\Dashboard\Admin\SubCategory;

use App\Http\Resources\V1\Dashboard\Product\SubCategoryProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryShowResource extends JsonResource
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
            'translations' => $this->all_translations,
            'total_orders' => 0,
            'total_products' => $this->products_count,
            'total_sales' => 0,
            'total_revenue' => 0,
            'average_rate' => 0,
            'image' => $this->image,
            'name' => $this->name,
            'category' => $this->category->name,
            'products_count' => $this->products_count,
            'category_id' => $this->category_id,
            'tags' => $this->tags,
            'activation' => $this->is_active,
            'products' => SubCategoryProductResource::collection($this->products),
        ];
    }
}
