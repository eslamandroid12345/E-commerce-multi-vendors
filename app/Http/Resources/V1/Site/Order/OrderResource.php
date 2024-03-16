<?php

namespace App\Http\Resources\V1\Site\Order;

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
                    'id' => $this->id,
                    'grand_total' => $this->grand_total,
                    'payment_method' => $this->payment_method,
                    'payment_gateway' => $this->payment_gateway,
                    'user' => $this->user->name,
        ];
    }
}

