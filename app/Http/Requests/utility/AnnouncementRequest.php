<?php

namespace App\Http\Requests\utility;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'status' => 'required|string',
            'expire_after' => 'required|integer',
            'show_staff' => 'nullable|boolean',
            'show_clients' => 'nullable|boolean',
            'show_name' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'The subject is required.',
            'subject.max' => 'The subject must not exceed 255 characters.',
            'message.required' => 'The message is required.',
            'message.max' => 'The message must not exceed 5000 characters.',
            'status.required' => 'The status is required.',
            'expire_after.required' => 'The expire after is required.',
            'show_staff.boolean' => 'The show staff field must be true or false.',
            'show_clients.boolean' => 'The show clients field must be true or false.',
            'show_name.boolean' => 'The show name field must be true or false.',
            'created_by.exists' => 'The creator must be a valid user.',
        ];
    }
}
