<?php

namespace App\Http\Requests\request;

use Illuminate\Foundation\Http\FormRequest;

class MoneyRequestRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

        return [
            'client'        => 'nullable',
            'project'       => 'nullable',
            'task'          => 'nullable',
            'related'       => 'nullable|string|max:255',
            'related_work'  => 'nullable|string|max:255',
            'subject'       => 'required|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'description'   => 'nullable|string|max:1024',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'duration'      => 'required|integer',
            'duration_type' => 'required|string|max:50',
            'follower'      => 'nullable',
            'handover'      => 'nullable',
            'approver'      => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'related_work.string'   => 'The related work must be a string.',
            'related_work.max'      => 'The related work may not be greater than 255 characters.',
            'amount.required'       => 'The amount is required.',
            'amount.numeric'        => 'The amount must be a number.',
            'amount.min'            => 'The amount must be at least 0.',
            'subject.required'      => 'The subject is required.',
            'subject.string'        => 'The subject must be a string.',
            'subject.max'           => 'The subject may not be greater than 255 characters.',
            'description.string'    => 'The description must be a string.',
            'description.max'       => 'The description may not be greater than 1024 characters.',
            'start_date.required'         => 'The start date is required.',
            'start_date.date'             => 'The start date must be a valid date.',
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
