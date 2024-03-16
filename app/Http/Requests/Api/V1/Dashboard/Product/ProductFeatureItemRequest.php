<?php

namespace App\Http\Requests\Api\V1\Dashboard\Product;

use App\Rules\ProductFeatureItemBelongsProduct;
use Illuminate\Foundation\Http\FormRequest;

class ProductFeatureItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prices' => 'required|array',
            'prices.*.id' => ['required','numeric','exists:product_feature_items,id',new ProductFeatureItemBelongsProduct()],
            'prices.*.discount' => 'required|numeric',
            'prices.*.product_price' => 'required|numeric',
            'prices.*.price' => 'required|numeric',
            'prices.*.quantity' => 'required|numeric',
        ];
    }


    public function messages(): array
    {
        return [
            'prices.required' => __('dashboard_api.prices_required'),
            'prices.array' =>  __('dashboard_api.prices_array'),
            'prices.*.id.required' =>  __('dashboard_api.prices_id_required'),
            'prices.*.id.numeric' =>  __('dashboard_api.prices_id_numeric'),
            'prices.*.id.exists' =>  __('dashboard_api.prices_id_exists'),
            'prices.*.product_price.required' =>  __('dashboard_api.prices_product_price_required'),
            'prices.*.discount.required' =>  __('dashboard_api.prices_discount_required'),
            'prices.*.discount.numeric' =>  __('dashboard_api.prices_discount_numeric'),
            'prices.*.product_price.numeric' =>  __('dashboard_api.prices_product_price_numeric'),
            'prices.*.price.required' =>  __('dashboard_api.prices_price_required'),
            'prices.*.price.numeric' =>  __('dashboard_api.prices_price_numeric'),
            'prices.*.quantity.required' =>  __('dashboard_api.prices_quantity_required'),
            'prices.*.quantity.numeric' =>  __('dashboard_api.prices_quantity_numeric'),
        ];
    }

}
