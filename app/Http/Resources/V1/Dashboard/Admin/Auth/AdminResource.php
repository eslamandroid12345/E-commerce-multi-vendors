<?php

namespace App\Http\Resources\V1\Dashboard\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'store_name' => $this->store_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_type' => $this->user_type,
            'is_active' => $this->is_active == 1 ? 'active' : 'not_active',
            'token' => 'Bearer '.$this->token,
            'roles' => new PermissionResource($this->rolesAdmin()),
            'permissions' => PermissionResource::collection($this->permissionsAdmin()),
        ];
    }
}
