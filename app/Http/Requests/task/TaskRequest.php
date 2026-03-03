<?php

namespace App\Http\Requests\task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'project_id'       => 'nullable|integer|exists:projects,id',
            'client_id'        => 'nullable|integer|exists:clients,id',
            'subject'          => 'required|string|max:255',
            'status'           => 'required|string|max:50',
            'date'             => 'required|date',
            'due_date'         => 'nullable|date|after_or_equal:date',
            'priority'         => 'nullable|string',
            'related'          => 'required|string|max:20',
            'description'      => 'nullable|string|max:1024',
            'type'             => 'nullable|string|max:20',
            'is_billed'        => 'required|boolean',
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
            'project_id.integer'       => 'The project ID must be an integer.',
            'project_id.exists'        => 'The specified project does not exist.',
            'client_id.integer'        => 'The client ID must be an integer.',
            'client_id.exists'         => 'The specified client does not exist.',
            'subject.required'         => 'The subject is required.',
            'subject.string'           => 'The subject must be a string.',
            'subject.max'              => 'The subject may not be greater than 100 characters.',
            'status.required'          => 'The status is required.',
            'status.string'            => 'The status must be a string.',
            'status.max'               => 'The status may not be greater than 50 characters.',
            'date.required'            => 'The start date is required.',
            'date.date'                => 'The start date must be a valid date.',
            'due_date.date'            => 'The due date must be a valid date.',
            'due_date.after_or_equal'  => 'The due date must be after or equal to the start date.',
            'priority.string'          => 'The priority must be a string.',
            'related.required'         => 'The related field is required.',
            'related.string'           => 'The related field must be a string.',
            'related.max'              => 'The related field may not be greater than 20 characters.',
            'description.string'       => 'The description must be a string.',
            'description.max'          => 'The description may not be greater than 1024 characters.',
            'type.string'              => 'The type must be a string.',
            'type.max'                 => 'The type may not be greater than 20 characters.',
            'is_billed.required'       => 'The billable option is required.',
            'is_billed.boolean'        => 'The billable option field must be true or false.',
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
