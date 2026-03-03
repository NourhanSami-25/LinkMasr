<?php

namespace App\Http\Requests\finance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PymentRequest extends FormRequest
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
        $pymentId = $this->route('pyment    ');

        return [
            'task_id'              => 'nullable|exists:tasks,id',
            'client_id'            => 'nullable|exists:clients,id',
            'invoice_id'           => 'nullable|exists:invoices,id',
            'pymentRequest_id'    => 'nullable|exists:paymentRequests,id',
            'creditNote_id'       => 'nullable|exists:creditNotes,id',
            'related'              => 'nullable|max:50',
            'client_name'          => 'nullable|max:255',

            'number' => [
                'required',
                'integer',
                $isUpdate
                    ? Rule::unique('pyments', 'number')->ignore($pymentId)
                    : 'unique:pyments,number',
            ],

            'subject'              => 'nullable|string|max:255',
            'total'                => 'required|numeric|min:0',
            'date'                 => 'required|date',
            'payment_mode'         => 'nullable|string|max:50',
            'payment_method'       => 'nullable|string|max:50',
            'transaction_number'   => 'nullable|string|max:50',
            'currency'             => 'required|string|max:50',
            'note'                 => 'nullable|string|max:1024',
            'created_by'           => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'project_id.exists'            => 'The selected project does not exist.',
            'task_id.exists'               => 'The selected task does not exist.',
            'client_id.exists'             => 'The selected client does not exist.',
            'invoice_id.exists'            => 'The selected invoice does not exist.',
            'pymentRequest_id.exists'     => 'The selected payment request does not exist.',
            'creditNote_id.exists'        => 'The selected credit note does not exist.',
            'related.max'                  => 'The related may not be greater than 50 characters.',
            'number.required'              => 'The payment number is required.',
            'number.unique'                => 'The payment number must be unique.',
            'subject.max'                  => 'The subject may not be greater than 255 characters.',
            'total.required'               => 'The total field is required.',
            'total.numeric'                => 'The total must be a valid number.',
            'total.min'                    => 'The total must be at least 0.',
            'date.required'                => 'The payment date field is required.',
            'date.date'                    => 'The payment date must be a valid date.',
            'payment_mode.max'             => 'The payment mode may not be greater than 50 characters.',
            'payment_method.max'           => 'The payment method may not be greater than 50 characters.',
            'transaction_number.max'       => 'The transaction number may not be greater than 50 characters.',
            'currency.required'            => 'The currency field is required.',
            'note.max'                     => 'The note may not be greater than 1024 characters.',
            'created_by.exists'            => 'The user who created this entry does not exist.',
        ];
    }
}
