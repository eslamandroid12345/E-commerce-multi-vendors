<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductFeature extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function details(): HasMany
    {
        return $this->hasMany(ProductFeatureDetail::class);
    }

    public function product(): BelongsTo
    {

        return $this->belongsTo(Product::class,'product_id','id');
    }
}
