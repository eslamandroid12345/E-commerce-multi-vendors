<?php

namespace App\Http\Requests\Api\V1\Site\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
//                    'grand_total' => 'required',
                    'payment_method' => 'required',
                    'payment_gateway' => 'required',
                    'user_id' => 'required',
                ];
    }

}
