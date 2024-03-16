<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Category;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'content' => $this->collection,
            'pagination' => new PaginationResource($this),
        ];
    }
}
