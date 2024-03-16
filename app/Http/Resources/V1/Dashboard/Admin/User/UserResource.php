<?php

namespace App\Http\Resources\V1\Dashboard\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            'activation' => $this->is_active == 1 ? 'active' : 'not_active',
            'total_orders' => $this->orders_count,
            'total_products' => $this->products_count,
            'total_visitors' => 0,
            'new_orders' => $this->new_orders_count,
            'orders' => UserOrdersResource::collection($this->orders),
        ];
    }
}
