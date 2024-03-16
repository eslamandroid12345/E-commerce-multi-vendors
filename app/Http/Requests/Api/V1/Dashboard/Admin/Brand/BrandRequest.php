<?php

namespace App\Http\Requests\Api\V1\dashboard\Admin\Brand;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                 'is_active' => 'required|boolean',

            ];
    }
}
