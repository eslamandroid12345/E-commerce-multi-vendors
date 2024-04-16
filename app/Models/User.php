<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function image() : Attribute
    {
        return Attribute::get(
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }


    public function token()
    {
        return JWTAuth::fromUser($this);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'user_id','id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class,'user_id','id');
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(OrderDetail::class,Order::class,'user_id','order_id','id','id');
    }

    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    public function getOrdersCountAttribute(): int
    {
        return $this->orders()->count();
    }

    public function getNewOrdersCountAttribute(): int
    {
        return $this->orders()->where('order_status','=','pending')->count();
    }
}
