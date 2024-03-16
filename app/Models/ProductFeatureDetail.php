<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeatureDetail extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function product_feature(): BelongsTo
    {
        return $this->belongsTo(ProductFeature::class,'product_feature_id','id');
    }


}
