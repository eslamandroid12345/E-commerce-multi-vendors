<?php

namespace App\Http\Resources\V1\Dashboard\Admin\SubCategory;

use App\Http\Resources\V1\Dashboard\Product\SubCategoryProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryItemResource extends JsonResource
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
            'items' => $this->products_count,
            'name' => $this->name,
            'products' => SubCategoryProductResource::collection($this->products)
        ];
    }
}
