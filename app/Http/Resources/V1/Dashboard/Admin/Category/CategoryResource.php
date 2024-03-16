<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Category;

use App\Http\Resources\V1\Dashboard\Admin\SubCategory\SubCategoryItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'tags' => $this->tags,
            'sub_categories_count' => $this->sub_categories_count,
            'total_products' => $this->products_count,
            'activation' => $this->is_active,

        ];
    }
}
