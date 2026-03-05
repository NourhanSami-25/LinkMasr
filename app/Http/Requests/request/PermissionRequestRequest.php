<?php

namespace App\Http\Requests\request;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

        return [
            'subject'       => 'required|string|max:255',
            'description'   => 'nullable|string|max:1024',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'duration'      => 'required|integer',
            'duration_type' => 'required|string|max:50',
            'follower'      => 'nullable',
            'handover'      => 'nullable',
            'approver_id'   => 'nullable',
            'approver_name' => 'nullable',
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
            'start_date.required'   => 'The start date is required.',
            'start_date.date'       => 'The start date must be a valid date.',
            'end_date.required'     => 'The end date is required.',
            'end_date.date'         => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'duration.integer' => 'Duration must be an integer.',
            'duration.required' => 'Duration is required.',
            'duration_type.string' => 'Duration Type must be an string.',
            'duration_type.required' => 'Duration Type is required.',

        ];
    }
}
