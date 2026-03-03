<?php

namespace App\Http\Requests\hr;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Modify this if you have specific authorization logic
    }

    public function rules()
    {
        return [
            'sector_id' => 'nullable|integer',
            'manager_id' => 'required|integer',
            'subject' => 'required|string|max:255',
            'email' => 'nullable|email|max:50',
            'status' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'manager_id.required' => 'The manager ID is required.',
            'manager_id.integer' => 'The manager ID must be an integer.',
            'sector_id.integer' => 'The manager ID must be an integer.',

            'subject.required' => 'The name field is required.',
            'subject.string' => 'The name must be a valid string.',
            'subject.max' => 'The name must not exceed 255 characters.',

            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 50 characters.',

            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
            'status.max' => 'The status must not exceed 50 characters.',
        ];
    }
}
