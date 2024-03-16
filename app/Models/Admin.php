<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class Admin extends Authenticatable implements JWTSubject,LaratrustUser
{
    use HasFactory,HasRolesAndPermissions;

    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function image() : Attribute
    {
        return Attribute::make(
            get: function ($value)
            {
                if ($value !== null)
                {
                    return url($value);
                }
                return null;
            }
        );
    }

    public function rolesAdmin()
    {
        return $this->roles()->first();
    }

    public function permissionsAdmin()
    {
        return $this->roles()->first()->permissions;
    }
}
