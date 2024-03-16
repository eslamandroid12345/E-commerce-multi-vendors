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
            'discount' => "10%",

        ];
    }
}
