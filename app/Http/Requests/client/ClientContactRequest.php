<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ClientContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'client_id'  => 'required|exists:clients,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:50',
            'position'   => 'nullable|string|max:50',
            'is_primary' => 'required|boolean',
            'status'     => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required'  => 'The client ID is required.',
            'client_id.exists'    => 'The selected client ID is invalid.',
            'name.required'       => 'The contact name is required.',
            'name.max'            => 'The contact name cannot exceed 255 characters.',
            'email.required'      => 'The email address is required.',
            'email.email'         => 'The email address must be valid.',
            'email.max'           => 'The email address cannot exceed 255 characters.',
            'email.unique'        => 'The email address is already taken.',
            'phone.max'           => 'The phone number cannot exceed 50 characters.',
            'position.max'        => 'The position cannot exceed 50 characters.',
            'is_primary.required' => 'The primary contact status is required.',
            'is_primary.boolean'  => 'The primary contact status must be true or false.',
            'status.required'     => 'The status field is required.',
        ];
    }
}
