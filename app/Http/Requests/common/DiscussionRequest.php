<?php

namespace App\Http\Requests\common;

use Illuminate\Foundation\Http\FormRequest;

class DiscussionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [];
    }

    public function messages()
    {
        return [];
    }
}
