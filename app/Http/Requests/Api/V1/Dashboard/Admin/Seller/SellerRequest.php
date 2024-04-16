<?php

namespace App\Http\Requests\Api\V1\Dashboard\Admin\Seller;
use Astrotomic\Translatable\Validation\RuleFactory;
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
                        'name' => 'required',
                        'store_name' => 'required',
                        'email' => 'required|email',
                        'phone' => 'required',
                        'password' => 'required|confirmed',
                        'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ];
        }
        if ($this->isMethod('put'))
        {
            return [
                        'name' => 'required',
                        'store_name' => 'required',
                        // 'email' => 'required|email',
                        // 'phone' => 'required',
                        'email' => 'required|unique:admins,email,'.$this->id,
                        'phone' => 'required|unique:admins,phone,'.$this->id,
                        'password' => 'nullable|confirmed',
                        'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ];
        }
    }
}
