<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class BillingAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id'       => 'required|exists:clients,id',
            'bank_name'       => 'nullable|string|max:255',
            'address'         => 'nullable|string|max:100',
            'le_account'      => 'nullable|string|max:100',
            'le_iban'         => 'nullable|string|max:100',
            'le_swift_code'   => 'nullable|string|max:100',
            'us_account'      => 'nullable|string|max:100',
            'us_iban'         => 'nullable|string|max:100',
            'us_swift_code'   => 'nullable|string|max:100',
            'status'          => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required'      => 'The client ID is required.',
            'client_id.exists'        => 'The selected client ID does not exist.',
            'bank_name.string'        => 'The bank name must be a string.',
            'address.string'          => 'The address must be a string.',
            'le_account.string'       => 'The local account must be a string.',
            'le_iban.string'          => 'The local IBAN must be a string.',
            'le_swift_code.string'    => 'The local SWIFT code must be a string.',
            'us_account.string'       => 'The US account must be a string.',
            'us_iban.string'          => 'The US IBAN must be a string.',
            'us_swift_code.string'    => 'The US SWIFT code must be a string.',
            'status.required'         => 'The status is required.',
        ];
    }
}
