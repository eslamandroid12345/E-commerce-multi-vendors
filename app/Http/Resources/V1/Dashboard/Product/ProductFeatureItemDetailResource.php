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

    // private static $data;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->productFeatureItem?->price,
            'quantity' => $this->productFeatureItem?->quantity,
            'product_price' => $this->productFeatureItem?->product_price,
            'discount' => $this->productFeatureItem?->discount,
            'feature_name' => $this->productFeatureItemDetail->product_feature->name,
            'discrimination' => $this->productFeatureItemDetail->product_feature->discrimination,
            'feature_detail' => $this->productFeatureItemDetail->content,
        ];
    }

    // public static function _collection($resource, $data = null)
    // {
    //     self::$data = $data;
    //     return parent::collection($resource);
    // }
}
