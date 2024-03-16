<?php

namespace App\Http\Resources\V1\Dashboard\Admin\SubCategory;

use App\Http\Resources\V1\Dashboard\Product\SubCategoryProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'category' => $this->category->name,
            'products_count' => $this->products_count,
            'tags' => $this->tags,
            'activation' => $this->is_active,
        ];
    }
}
