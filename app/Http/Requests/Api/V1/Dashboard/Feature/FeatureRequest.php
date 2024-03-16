<?php

namespace App\Http\Requests\Api\V1\Dashboard\Feature;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
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
            'productFeature' => 'required|array',
            'productFeature.*.name' => 'required|string',
            'productFeature.*.discrimination' => 'nullable|string',
            'productFeature.*.quantity' => 'required|integer|min:1',
            'productFeature.*.details' => 'required|array',
            'productFeature.*.details.content' => 'required|array',
            'productFeature.*.details.content.*' => 'required|string',
        ];
    }
}
