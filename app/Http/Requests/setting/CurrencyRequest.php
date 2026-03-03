<?php

namespace App\Http\Requests\setting;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
    public function rules()
    {
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

        return [
            'name' => 'required|string|max:20',
            'code' => 'required|string|max:5',
            'symbol' => 'required|string|max:5',
            'decimal_separator' => 'required|string|max:5',
            'thousand_separator' => 'required|string|max:5',
            'currency_placement' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 20 characters.',

            'code.required' => 'The code field is required.',
            'code.max' => 'The code may not be greater than 5 characters.',

            'symbol.required' => 'The symbol field is required.',
            'symbol.max' => 'The symbol may not be greater than 5 characters.',

            'decimal_separator.required' => 'The decimal separator field is required.',
            'decimal_separator.max' => 'The decimal separator may not be greater than 5 characters.',

            'thousand_separator.required' => 'The thousand separator field is required.',
            'thousand_separator.max' => 'The thousand separator may not be greater than 5 characters.',

            'currency_placement.required' => 'The currency placement field is required.',
            'currency_placement.max' => 'The currency placement may not be greater than 20 characters.',
        ];
    }
}
