<?php

namespace App\Http\Requests\request;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequestRequest extends FormRequest
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
            'subject'       => 'required|string|max:255',
            'description'   => 'nullable|string|max:1024',
            'follower'      => 'nullable',
            'handover'      => 'nullable',
            'approver'      => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'subject.required'      => 'The subject is required.',
            'subject.string'        => 'The subject must be a string.',
            'subject.max'           => 'The subject may not be greater than 255 characters.',
            'description.string'    => 'The description must be a string.',
            'description.max'       => 'The description may not be greater than 1024 characters.',

        ];
    }
}
