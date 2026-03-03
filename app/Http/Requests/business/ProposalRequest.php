<?php

namespace App\Http\Requests\business;

use Illuminate\Foundation\Http\FormRequest;

class ProposalRequest extends FormRequest
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
            'project_id'   => 'nullable|exists:projects,id',
            'task_id'      => 'nullable|exists:tasks,id',
            'client_id'    => 'nullable|exists:clients,id',
            'number'       => 'required|integer|unique:invoices,number',
            'subject'      => 'required|string|max:255',
            'description'  => 'nullable|string|max:1024',
            'date'         => 'required|date',
            'due_date'     => 'nullable|date|after_or_equal:date',
            'currency'     => 'required|string|max:10',
            'sale_agent'   => 'nullable|exists:users,id',
            'message'      => 'nullable|string|max:1024',
            'total'        => 'nullable|numeric|min:0',
            'status'       => 'nullable|string|max:20',
            'created_by'   => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'project_id.exists'    => 'The selected project does not exist.',
            'task_id.exists'       => 'The selected task does not exist.',
            'client_id.exists'     => 'The selected client does not exist.',
            'number.required'      => 'The proposal number is required.',
            'number.integer'       => 'The proposal number must be a valid integer.',
            'subject.required'     => 'The subject is required.',
            'subject.max'          => 'The subject may not be greater than 255 characters.',
            'date.required'        => 'The date is required.',
            'date.date'            => 'The date must be a valid date.',
            'due_date.date'        => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'The due date must be on or after the date.',
            'currency.required'    => 'The currency is required.',
            'currency.max'         => 'The currency may not be greater than 10 characters.',
            'total.numeric'        => 'The total amount must be a valid number.',
            'status.max'           => 'The status may not be greater than 20 characters.',
            'sale_agent.exists'    => 'The selected sale agent does not exist.',
            'created_by.exists'    => 'The creator does not exist.',
        ];
    }
}
