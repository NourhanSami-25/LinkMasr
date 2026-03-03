<?php

namespace App\Http\Requests\reminder;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
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
            'referable_id'        => 'required|integer',
            'referable_type'      => 'required|string|max:255',
            'subject'             => 'required|string|max:255',
            'date'                => 'required|date',
            'remind_before'       => 'nullable|integer|min:0',
            'remind_at_event'     => 'nullable|boolean',
            'before_reminded'     => 'nullable|boolean',
            'event_reminded'      => 'nullable|boolean',
            'priority'            => 'nullable|string|max:50',
            'status'              => 'nullable|string|max:50',
            'is_repeated'         => 'nullable|boolean',
            'repeat_every'        => 'nullable|integer|min:1',
            'repeat_every_type'   => 'nullable|string',
            'members'             => 'nullable',
            'created_by'          => 'nullable|integer|exists:users,id',



        ];
    }

    public function messages()
    {
        return [
            'referable_id.required'        => 'The referable ID is required.',
            'referable_id.integer'         => 'The referable ID must be an integer.',
            'referable_type.required'      => 'The referable type is required.',
            'referable_type.string'        => 'The referable type must be a string.',
            'referable_type.max'           => 'The referable type must not exceed 255 characters.',
            'subject.string'               => 'The subject must be a string.',
            'subject.max'                  => 'The subject must not exceed 255 characters.',
            'date.required'                => 'The date is required.',
            'date.date'                    => 'The date must be a valid date format.',
            'remind_before.integer'        => 'Remind before must be a valid number.',
            'remind_before.min'            => 'Remind before cannot be negative.',
            'remind_at_event.boolean'      => 'Remind at event must be true or false.',
            'priority.string'              => 'The priority must be a string.',
            'priority.max'                 => 'The priority must not exceed 50 characters.',
            'status.string'                => 'The status must be a string.',
            'status.max'                   => 'The status must not exceed 50 characters.',
            'is_repeated.boolean'          => 'The repeated status must be true or false.',
            'repeat_every.integer'         => 'The repeat interval must be an integer.',
            'repeat_every.min'             => 'The repeat interval must be at least 1.',
            'repeat_every_type.string'     => 'The repeat type must be a string.',
            'created_by.required'          => 'The creator is required.',
            'created_by.integer'           => 'The creator ID must be an integer.',
            'created_by.exists'            => 'The creator must exist in the users table.',
        ];
    }
}
