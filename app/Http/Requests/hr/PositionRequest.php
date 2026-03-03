<?php

namespace App\Http\Requests\hr;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'subject' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'The subject field is required.',
            'subject.string' => 'The subject must be a valid string.',
            'subject.max' => 'The subject must not exceed 255 characters.',
        ];
    }
}
