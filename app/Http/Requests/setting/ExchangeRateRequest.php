<?php

namespace App\Http\Requests\setting;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRateRequest extends FormRequest
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
        $id = $this->route('exchangeRate'); // gets ID or model from route
        return [
            'currency' => 'required|string|size:3|unique:exchange_rates,currency,' . $id,
            'rate' => 'required|numeric|min:0.000001|max:1000000',
        ];
    }

    public function messages(): array
    {
        return [
            'currency.required' => 'The currency code is required.',
            'currency.string' => 'The currency must be a valid string (e.g., USD).',
            'currency.size' => 'The currency code must be exactly 3 letters (e.g., USD, EUR).',
            'currency.unique' => 'This currency already exists in the exchange rates list.',

            'rate.required' => 'Please enter the exchange rate value.',
            'rate.numeric' => 'The rate must be a valid number.',
            'rate.min' => 'The rate value must be greater than zero.',
            'rate.max' => 'The rate value is too large.',
        ];
    }
    
}
