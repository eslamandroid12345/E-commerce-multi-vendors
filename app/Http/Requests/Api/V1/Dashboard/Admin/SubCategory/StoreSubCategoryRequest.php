<?php

namespace App\Http\Requests\Api\V1\Dashboard\Admin\SubCategory;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
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
            ]),
            'image' => 'required|mimes:jpeg,png,jpg',
            'tags' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'required|boolean',
        ];
    }



    public function messages(): array
    {
        return [
            'image.required' => __('dashboard_api.image_required'),
            'image.mimes' => __('dashboard_api.image_mimes'),
            'tags.required' => __('dashboard_api.tags_required'),
            'tags.max' => __('dashboard_api.tags_max'),
            'category_id.required' => __('dashboard_api.category_id_required'),
            'category_id.exists' => __('dashboard_api.category_id_exists'),
        ];
    }


}
