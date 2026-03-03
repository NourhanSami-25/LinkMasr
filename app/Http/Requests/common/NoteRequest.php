<?php

namespace App\Http\Requests\common;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'model_id' => 'required|integer',
            'model_type' => 'required|string',
            'content' => 'required|string|max:1024',
            'created_by' => 'nullable|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'model_id.required' => 'The model ID is required.',
            'model_id.integer' => 'The model ID must be an integer.',
            'model_type.required' => 'The model type is required.',
            'model_type.string' => 'The model type must be a string.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a valid string.',
            'content.max' => 'The content must not exceed 1024 characters.',
            'created_by.string' => 'The created by field must be a valid string.',
            'created_by.max' => 'The created by field must not exceed 50 characters.',
        ];
    }
}
