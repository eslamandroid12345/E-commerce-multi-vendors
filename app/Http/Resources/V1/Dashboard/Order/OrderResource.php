<?php

namespace App\Http\Resources\V1\Dashboard\Order;
use Carbon\Carbon;
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
            'name' => $this->user->name,
            'items' => $this->items_count,
            'price' => $this->grand_total,
//            'price' => $this->totalOrderPrice,
            'place_Date' => $this->created_at->format('d-m-Y'),
            'payment_method' => $this->payment_method,
            'payment_gateway' => $this->payment_gateway,
            'status' => $this->order_status,
//            'details' => OrderDetailsResource::collection($this->details),
        ];
    }
}
