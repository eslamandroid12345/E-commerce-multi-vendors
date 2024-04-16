<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Home;

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
            'customer' => $this->user->name,
            'email' => $this->user->email,
            'total' => $this->grand_total,
            'time' => $this->created_at->diffForHumans(),

        ];
    }
}
