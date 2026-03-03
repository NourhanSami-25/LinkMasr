<?php

namespace App\Http\Requests\business;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
        
            'client_name'     => 'required|string|max:255',
            'address'         => 'nullable|string|max:255',
            'number'          => 'required|integer|min:1',
            'subject'         => 'required|string|max:255',
            'email'           => 'nullable|email|max:50',
            'website'         => 'nullable|max:255',
            'phone'           => 'nullable|string|max:20',
            'lead_value'      => 'nullable|numeric|min:0',
            'source'          => 'required|string|max:20',
            'sale_agent'      => 'nullable|exists:users,id',
            'created_since'   => 'nullable|date',
            'status'          => 'nullable|string|max:20',
            'created_by'      => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
           
            'client_name.required'    => 'Client name is required',
            'client_name.max'         => 'Client name must not exceed 255 characters.',
            'address.max'             => 'Client name must not exceed 255 characters.',
            'number.required'         => 'The lead number is required.',
            'number.integer'          => 'The lead number must be an integer.',
            'subject.required'        => 'The subject is required.',
            'subject.max'             => 'The subject must not exceed 255 characters.',
            'email.email'             => 'The email must be a valid email address.',
            'phone.max'               => 'Phone number must not exceed 20 characters.',
            'lead_value.numeric'      => 'Lead value must be a valid number.',
            'source.required'         => 'The source is required.',
            'sale_agent.exists'       => 'The selected sales agent does not exist.',
            'created_since.date'      => 'Created since must be a valid date.',
            'status.max'              => 'Status must not exceed 20 characters.',
        ];
    }
}
