<?php

namespace App\Rules;

use App\Models\ProductFeatureItem;
use Illuminate\Contracts\Validation\Rule;
class ProductFeatureItemBelongsProduct implements Rule
{
    public function passes($attribute, $value): bool
    {


        return ProductFeatureItem::query()
        ->where('id', $value)
            ->where('product_id','=',request('id'))
            ->exists();
    }

    public function message(): string
    {

        return __('dashboard_api.item_belongs_to_product');
    }
}
