<?php

namespace App\Http\Requests\setting;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
