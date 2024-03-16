<?php

namespace App\Http\Requests\Api\V1\Dashboard\Admin\Order;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class FilterOrderRequest extends FormRequest
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
                        'category_id' => 'nullable',
                        'brand_id' => 'nullable',
                        'status' => 'nullable',
                        'placed_date' => 'nullable',
                        'payment_gateway' => 'nullable',
                        'price_from' => 'nullable|numeric',
                        'price_to' => 'nullable|required_with:price_from|numeric|gt:price_from',
                    ];
    }
}
