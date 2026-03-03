<?php

namespace App\Http\Requests\hr;

use Illuminate\Foundation\Http\FormRequest;

class BalanceRequest extends FormRequest
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
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';
        
         return [
            'user_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2000|max:2100',
            'total_days' => 'required|numeric|min:0|max:365',
            'used_days' => 'numeric|min:0|max:365',
        ];
    }
}
