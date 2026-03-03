<?php

namespace App\Http\Requests\project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'client_id'        => 'nullable|integer|exists:clients,id',
            'subject'          => 'required|string|max:255',
            'status'           => 'required|string|max:50',
            'date'             => 'required|date',
            'due_date'         => 'nullable|date|after_or_equal:date',
            'billing_type'     => 'nullable',
            'description'      => 'nullable|string|max:1024',
            'is_repeated'      => 'nullable',
            'repeat_every'     => 'nullable|string|max:10',
            'repeat_counter'   => 'nullable|integer|min:0',
            'assignees'        => 'nullable',
            'followers'        => 'nullable',
            'created_by'       => 'nullable|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [

            'client_id.integer'        => 'The client ID must be an integer.',
            'client_id.exists'         => 'The specified client does not exist.',
            'subject.required'         => 'The subject is required.',
            'subject.string'           => 'The subject must be a string.',
            'subject.max'              => 'The subject may not be greater than 255 characters.',
            'status.required'          => 'The status is required.',
            'status.string'            => 'The status must be a string.',
            'status.max'               => 'The status may not be greater than 50 characters.',
            'date.required'            => 'The start date is required.',
            'date.date'                => 'The start date must be a valid date.',
            'due_date.date'            => 'The due date must be a valid date.',
            'due_date.after_or_equal'  => 'The due date must be after or equal to the start date.',
            'description.string'       => 'The description must be a string.',
            'description.max'          => 'The description may not be greater than 1024 characters.',
            'is_repeated.boolean'      => 'The is_repeated field must be true or false.',
            'repeat_every.string'      => 'The repeat_every field must be a string.',
            'repeat_every.max'         => 'The repeat_every field may not be greater than 10 characters.',
            'repeat_counter.integer'   => 'The repeat_counter must be an integer.',
            'repeat_counter.min'       => 'The repeat_counter must be at least 0.',
            'created_by.integer'       => 'The created_by field must be an integer.',
            'created_by.exists'        => 'The specified creator does not exist.',
        ];
    }
}
