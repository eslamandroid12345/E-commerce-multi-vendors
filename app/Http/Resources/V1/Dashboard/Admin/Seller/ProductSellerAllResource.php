<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSellerAllResource extends JsonResource
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
                    'price' => 0,
                    'image' =>   url($this->images->first()->image),
                ];
    }
}

