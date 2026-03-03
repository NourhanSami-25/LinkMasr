<?php

namespace App\Http\Requests\common;

use Illuminate\Foundation\Http\FormRequest;

class DiscussionMessageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'discussion_id' => 'required|exists:discussions,id',
            'message' => 'required|string',
        ];
    }

    public function messages()
    {
        return [];
    }
}
