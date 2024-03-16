<?php

namespace App\Http\Resources\V1\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFeatureItemDetailResource extends JsonResource
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
            'feature_name' => $this->productFeatureItemDetail->product_feature->name,
            'discrimination' => $this->productFeatureItemDetail->product_feature->discrimination,
            'feature_detail' => $this->productFeatureItemDetail->content,
        ];
    }
}
