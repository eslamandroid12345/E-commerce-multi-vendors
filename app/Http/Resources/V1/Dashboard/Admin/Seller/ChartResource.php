<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChartResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                    'category' => $this->name,
                    'value' => 100,
                ];
    }
}

