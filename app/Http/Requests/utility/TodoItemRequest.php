<?php

namespace App\Http\Requests\utility;

use Illuminate\Foundation\Http\FormRequest;

class TodoItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'todo_id'   => 'required|exists:todos,id|integer',
            'subject'   => 'required|string|max:255',
            'date'      => 'date',
            'status'    => 'required|string|max:50',
        ];
    }


    public function messages()
    {
        return [
            'todo_id.required'   => 'The related To-Do item is required.',
            'todo_id.exists'     => 'The selected To-Do item does not exist.',
            'subject.required'   => 'The subject field is required.',
            'subject.max'        => 'The subject must not exceed 255 characters.',
            'date.date'          => 'Please provide a valid date.',
            'status.required'    => 'The status field is required.',
            'status.max'         => 'The status must not exceed 50 characters.',
        ];
    }
}
