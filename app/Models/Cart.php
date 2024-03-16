<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function totalAmount() : Attribute {
        return Attribute::get(
            get: function () {

                $productFeatureItem = $this->productFeatureItem();
                $price = $productFeatureItem->price;
                $quantity = $this->quantity;
                $discount = $productFeatureItem->discount;
                $total = $price * $quantity;
                if($discount > 0)
                {
                    $discountedAmount = $total * $discount / 100;
                    $total -= $discountedAmount;
                }
                return $total;
            }
        );
    }


    public function productFeatureItem(): BelongsTo
    {
        return $this->belongsTo(ProductFeatureItem::class,'product_feature_item_id','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
