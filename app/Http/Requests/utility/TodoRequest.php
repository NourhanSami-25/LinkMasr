<?php

namespace App\Http\Requests\utility;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'priority' => 'nullable|string',
            'status' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'The subject is required.',
            'subject.max' => 'The subject must not exceed 255 characters.',
            'description.max' => 'The description must not exceed 5000 characters.',
            'status.required' => 'The status is required.',
        ];
    }
}
