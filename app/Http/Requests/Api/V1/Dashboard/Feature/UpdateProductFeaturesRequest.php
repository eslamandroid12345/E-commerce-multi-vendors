<?php

namespace App\Http\Requests\Api\V1\Dashboard\Feature;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductFeaturesRequest extends FormRequest
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
            'productFeature.*.id' => 'required|exists:product_features,id',
            'productFeature.*.name' => 'required|string',
            'productFeature.*.discrimination' => 'required|string',
            'productFeature.*.details' => 'required|array',
            'productFeature.*.details.*.id' => 'required|exists:product_feature_details,id',
            'productFeature.*.details.*.content' => 'required',
        ];
    }
}
