<?php

namespace App\Http\Requests\Api\V1\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
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

            'is_active' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'is_active.required' => __('dashboard_api.is_active_required'),
            'is_active.boolean' => __('dashboard_api.is_active_boolean'),
        ];
    }
}
