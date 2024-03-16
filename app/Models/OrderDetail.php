<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productName() : Attribute {
        return Attribute::get(
            get: function ()
            {
                $this->productFeatureItem->product->name;
            }
        );
    }

    public function totalAmount() : Attribute {
        return Attribute::get(
            get: function ()
            {
                $price = $this->item_price;
                $quantity = $this->quantity;
                return $price * $quantity;
            }
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'seller_id','id');
    }

    public function productFeatureItem(): BelongsTo
    {
        return $this->belongsTo(ProductFeatureItem::class,'product_feature_item_id','id');
    }


}
