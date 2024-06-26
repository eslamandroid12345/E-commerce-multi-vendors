<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory,Translatable;

    public array $translatedAttributes = ['name'];

    protected $guarded = [];


    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function image() : Attribute {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }


    public function productsCount() : Attribute {
        return Attribute::get(
            get: function () {
               return $this->products()?->count();
            }
        );
    }


    public function allTranslations() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->translations()->select('id','name','locale')->get();

            }
        );
    }


    public function subCategoriesCount() : Attribute {
        return Attribute::get(
            get: function () {
                return $this->subCategories()?->count();
            }
        );
    }



}
