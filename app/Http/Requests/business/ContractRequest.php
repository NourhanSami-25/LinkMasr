<?php

namespace App\Http\Requests\business;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            'project_id'        => 'nullable|exists:projects,id',
            'task_id'           => 'nullable|exists:tasks,id',
            'client_id'         => 'nullable|exists:clients,id',
            'client_name'       => 'nullable|string|max:255',
            'number'            => 'required|integer|min:1',
            'subject'           => 'required|string|max:255',
            'description'       => 'nullable|string|max:1024',
            'type'              => 'nullable|string|max:50',
            'date'              => 'required|date',
            'due_date'          => 'nullable|date|after_or_equal:date',
            'currency'          => 'required|string|max:10',
            'sale_agent'        => 'nullable|exists:users,id',
            'content'           => 'nullable|string|max:3000',
            'signature'         => 'nullable|string|max:50',
            'visible_to_client' => 'nullable|boolean',
            'total'             => 'nullable|numeric|min:0',
            'status'            => 'nullable|string|max:50',
            'created_by'        => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'project_id.exists'        => 'The selected project does not exist.',
            'task_id.exists'           => 'The selected task does not exist.',
            'client_id.exists'         => 'The selected client does not exist.',
            'client_name.max'          => 'Client name must not exceed 255 characters.',
            'number.required'          => 'The contract number is required.',
            'number.integer'           => 'The contract number must be an integer.',
            'subject.required'         => 'The subject is required.',
            'subject.max'              => 'The subject must not exceed 255 characters.',
            'description.max'          => 'Description must not exceed 1024 characters.',
            'type.max'                 => 'The type must not exceed 50 characters.',
            'date.required'            => 'The date is required.',
            'due_date.after_or_equal'  => 'The due date must be on or after the date.',
            'currency.required'        => 'The currency is required.',
            'currency.max'             => 'Currency must not exceed 10 characters.',
            'sale_agent.exists'        => 'The selected sales agent does not exist.',
            'content.max'              => 'Content must not exceed 3000 characters.',
            'signature.max'            => 'Signature must not exceed 50 characters.',
            'visible_to_client.boolean' => 'Visible to client must be true or false.',
            'total.numeric'            => 'The total amount must be a valid number.',
            'status.max'               => 'Status must not exceed 50 characters.',
        ];
    }
}
