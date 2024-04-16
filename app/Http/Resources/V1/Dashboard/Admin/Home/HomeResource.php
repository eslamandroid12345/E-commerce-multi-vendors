<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'total_amount' => $this->grand_total,
            'ordered' => $this->ordered,
            'processed' => $this->processed,
            'shipped' => $this->shipped,
            'delivered' => $this->delivered,
            'total_visitors' => 1,
            'total_users' => $this->total_users,
            'total_categories' => $this->total_categories,
            'total_products' => $this->total_products,
            'total_orders' => $this->total_orders,
            'total_sellers' => $this->total_sellers,
            'category' => $this->category,
            'least_orders' => OrderResource::collection($this->orders),

        ];
    }
}
