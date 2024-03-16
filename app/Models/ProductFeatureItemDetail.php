<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeatureItemDetail extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function productFeatureItemDetail(): BelongsTo
    {
        return $this->belongsTo(ProductFeatureDetail::class,'product_feature_detail_id','id');
    }


}
