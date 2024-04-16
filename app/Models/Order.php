<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

    public function itemsCount() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->details()->count();
            }
        );
    }

    
}
