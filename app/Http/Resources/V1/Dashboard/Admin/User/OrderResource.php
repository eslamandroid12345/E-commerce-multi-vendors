<?php

namespace App\Http\Resources\V1\Dashboard\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'order_id' => $this->id,
            'placed_date' => $this->created_at->format('Y-m-d'),
            'status' => $this->order_status,

        ];
    }
}
