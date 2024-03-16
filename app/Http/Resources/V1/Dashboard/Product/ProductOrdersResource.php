<?php

namespace App\Http\Resources\V1\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrdersResource extends JsonResource
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
            'name' => $this->order->user->name,
            'placed_date' => $this->created_at->format('Y-m-d'),
            'status' => $this->item_status,
        ];
    }
}
