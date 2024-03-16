<?php

namespace App\Http\Requests\Api\V1\Dashboard\Product;

use App\Rules\CheckIdOfSeller;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
                ...RuleFactory::make([
                    '%name%' => 'required|max:255',
                    '%description%' => 'required|max:255',
                ]),
                'product_code' => 'required',
                'tags' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'is_active' => 'required|boolean',
                'brand_id' => 'required',
                'seller_id' => ['required', 'exists:admins,id', new CheckIdOfSeller()],
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
    }
}
