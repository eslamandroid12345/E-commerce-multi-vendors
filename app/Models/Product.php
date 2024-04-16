<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory,Translatable;

    public array $translatedAttributes = ['name','description'];

    protected $guarded = [];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'seller_id','id');
    }
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

    public function productFeatureItemPrice(): HasOne
    {
        return $this->hasOne(ProductFeatureItem::class,'product_id','id')->where('price','>',0);
    }

    public function totalAfterDiscount(): Attribute
    {
        return Attribute::get(function (){
                $price = $this->productFeatureItemPrice?->price;
                $discount = $this->productFeatureItemPrice?->discount;
                $discountAmount = $price * ($discount / 100);
                return  $price - $discountAmount;
        });
    }

    public function firstImage(): HasOne
    {
        return $this->hasOne(ProductImage::class,'product_id','id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductFeatureItem::class,'product_id','id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProductFeature::class,'product_id','id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductFeatureItem::class,'product_id','id');
    }

    public function pricesCount() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->prices()->count();
            }
        );
    }


    public function featuresCount() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->features()->count();

            }
        );
    }

    public function quantityCount() : Attribute {
        return Attribute::get(
            get: function () {
                return (int)$this->items()->sum('quantity');

            }
        );
    }


    public function allTranslations() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->translations()->select('id','name','description','locale')->get();

            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Count orders for product through product_feature_items belongs to product
    |--------------------------------------------------------------------------
    */
    public function orderDetails(): HasManyThrough
    {
        return $this->hasManyThrough(OrderDetail::class,ProductFeatureItem::class,'product_id','product_feature_item_id','id','id');
    }


    public function countOrders() : Attribute {
        return Attribute::get(
            get: function () {

                return $this->orderDetails()?->count();

            }
        );
    }

    public function countNewOrders() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->orderDetails()?->where('item_status','=','pending')->count();

            }
        );
    }

    public function productInStock()
    {
        return $this->productFeatureItemPrice->where('quantity', '>', 0)->count();
    }
}
