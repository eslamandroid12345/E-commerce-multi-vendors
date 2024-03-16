<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Category;

use App\Http\Resources\V1\Dashboard\Admin\SubCategory\SubCategoryItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShowResource extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'translations' => $this->all_translations,
            'sub_categories_count' => $this->sub_categories_count,
            'products_count' => $this->products_count,
            'activation' => $this->is_active,
            'total_orders' => 0,
            'total_products' => $this->products_count,
            'total_sales' => 0,
            'total_revenue' => 0,
            'tags' => $this->tags,
            'sub_categories' => SubCategoryItemResource::collection($this->subCategories),

        ];

    }
}
