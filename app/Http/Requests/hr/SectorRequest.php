<?php

namespace App\Http\Requests\hr;

use Illuminate\Foundation\Http\FormRequest;

class SectorRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Modify this if you have specific authorization logic
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Sector name is required.',
            'subject.max' => 'Sector name cannot exceed 255 characters.',
            'manager_id.required' => 'A manager must be assigned.',
            'manager_id.exists' => 'The selected manager does not exist.'
        ];
    }
}
