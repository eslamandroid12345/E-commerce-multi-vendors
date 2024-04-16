<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'seller_id','id');
    }

    public function category() : Attribute {
        return Attribute::get(
            get: function () {
                return Category::with(['products.orderDetails'])->get()->map(function ($category) {
                    $orderDetailsCount = $category->products->sum(function ($product) {
                        return $product->orderDetails->count();
                    });
                    return [
                        'name' => $category->name,
                        'value' => $orderDetailsCount,
                    ];
                });
            }
        );
    }


    ############### Start home api accessors ###############################################
    public function orders() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Order::query()->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->get();

            }
        );
    }


    public function grandTotal() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Order::query()->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->sum('grand_total');

            }
        );
    }

    public function ordered() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return OrderDetail::query()->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->where('item_status','=','pending')->count();

            }
        );
    }


    public function processed() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return OrderDetail::query()->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->where('item_status','=','prepared')->count();

            }
        );
    }


    public function shipped() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return OrderDetail::query()->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->where('item_status','=','out_for_delivery')->count();

            }
        );
    }


    public function delivered() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return OrderDetail::query()->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->where('item_status','=','delivered')->count();

            }
        );
    }

    public function totalUsers() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return User::query()->count();

            }
        );
    }


    public function totalCategories() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Category::query()->count();

            }
        );
    }


    public function totalProducts() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Product::query()->count();

            }
        );
    }


    public function totalOrders() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return OrderDetail::query()->count();

            }
        );
    }


    public function totalSellers() : Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Admin::query()->where('user_type','=','seller')->count();

            }
        );
    }

    ############### End home api accessors ###############################################



}
