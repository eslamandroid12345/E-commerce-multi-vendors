<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Feature;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
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
            'product' => $this->product->name,
            'feature' => $this->name,
            'discrimination' => $this->discrimination,
            'quantity' => $this->quantity,
            'details' => FeatureDetailsResource::collection($this->details),
        ];
    }
}
