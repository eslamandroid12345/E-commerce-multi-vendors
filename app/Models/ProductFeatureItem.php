<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductFeatureItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productFeatureItemDetail(): HasMany
    {
        return $this->hasMany(ProductFeatureItemDetail::class,'product_feature_item_id','id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class,'product_feature_item_id','id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
