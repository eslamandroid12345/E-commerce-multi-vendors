<?php

namespace App\Http\Resources\V1\Site\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
                    'user' => $this->user->name,
                    'product_feature_item_id' => $this->product_feature_item_id,
                    'quantity' => $this->quantity,
        ];
    }
}

