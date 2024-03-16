<?php

namespace App\Http\Requests\Api\V1\Dashboard\Seller;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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
        if ($this->isMethod('post'))
        {
            return [
                        'name' => 'required|max:255',
                        'email' => 'required|email',
                        'store_name' => 'required',
                        'phone' => 'required',
                        'password' => 'required|confirmed',
                        'image'=>'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ];
        }
        if ($this->isMethod('put'))
        {
            return [
                        'name_en' => 'required|max:255',
                        'name_ar' => 'required|max:255',
                        'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ];
        }
    }
}
