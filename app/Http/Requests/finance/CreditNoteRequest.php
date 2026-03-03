<?php

namespace App\Http\Requests\finance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreditNoteRequest extends FormRequest
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
        $creditNoteId = $this->route('creditNotes');

        return [
            'project_id' => 'nullable|integer',
            'task_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'invoice_id' => 'nullable|integer',
            'client_name' => 'string|max:255',
            'billing_address' => 'nullable|string|max:255',

            'number' => [
                'required',
                'integer',
                $isUpdate
                    ? Rule::unique('creditNotes', 'number')->ignore($creditNoteId)
                    : 'unique:creditNotes,number',
            ],

            'is_repeated' => 'nullable|boolean',
            'repeat_every' => 'nullable|string|max:255',
            'repeat_counter' => 'nullable|integer',

            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
            'currency' => 'required|string|max:10',
            'sale_agent' => 'nullable|string|max:50',


            'status' => 'nullable|string|max:50',
            'send_status' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1024',
            'admin_note' => 'nullable|string|max:1024',
            'client_note' => 'nullable|string|max:1024',

            'discount_type' => 'nullable|string|max:50',
            'discount_amount_type' => 'nullable|string|max:50',
            'tax' => 'nullable|string|max:255',
            'items_tax_value' => 'nullable|numeric|min:0',
            'overall_tax_value' => 'nullable|numeric|min:0',
            'adjustment' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'percentage_discount_value' => 'nullable|numeric|min:0',
            'fixed_discount' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'total_tax' => 'nullable|numeric|min:0',
            'total_discount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',

            'created_by' => 'nullable|integer',
            'action' => 'nullable',
            'create_payment' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.integer' => 'The project ID must be an integer.',
            'task_id.integer' => 'The task ID must be an integer.',
            'client_id.integer' => 'The client ID must be an integer.',

            'client_name.string' => 'Client name must be a valid string.',
            'client_name.max' => 'Client name must not exceed 255 characters.',

            'billing_address.string' => 'Billing address must be a valid string.',
            'billing_address.max' => 'Billing address must not exceed 255 characters.',

            'number.required' => 'CreditNote number is required.',
            'number.integer' => 'CreditNote number must be an integer.',
            'number.unique' => 'This creditNote number has already been taken.',

            'is_repeated.boolean' => 'Repeat value must be true or false.',
            'repeat_every.string' => 'Repeat every must be a string.',
            'repeat_every.max' => 'Repeat every must not exceed 255 characters.',
            'repeat_counter.integer' => 'Repeat counter must be an integer.',

            'date.required' => 'The creditNote date is required.',
            'date.date' => 'The creditNote date must be a valid date.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'Due date must be equal to or after the creditNote date.',

            'currency.required' => 'Currency is required.',
            'currency.string' => 'Currency must be a string.',
            'currency.max' => 'Currency must not exceed 10 characters.',

            'sale_agent.string' => 'Sale agent must be a valid string.',
            'sale_agent.max' => 'Sale agent must not exceed 50 characters.',

            'status.string' => 'Status must be a string.',
            'status.max' => 'Status must not exceed 50 characters.',
            'send_status.string' => 'Send status must be a string.',
            'send_status.max' => 'Send status must not exceed 50 characters.',

            'description.string' => 'Description must be a string.',
            'description.max' => 'Description must not exceed 1024 characters.',
            'admin_note.string' => 'Admin note must be a string.',
            'admin_note.max' => 'Admin note must not exceed 1024 characters.',
            'client_note.string' => 'Client note must be a string.',
            'client_note.max' => 'Client note must not exceed 1024 characters.',

            'discount_type.string' => 'Discount type must be a string.',
            'discount_type.max' => 'Discount type must not exceed 50 characters.',
            'discount_amount_type.string' => 'Discount amount type must be a string.',
            'discount_amount_type.max' => 'Discount amount type must not exceed 50 characters.',

            'tax.string' => 'Tax must be a valid string.',
            'tax.max' => 'Tax must not exceed 255 characters.',

            'items_tax_value.numeric' => 'Items tax value must be a number.',
            'items_tax_value.min' => 'Items tax value must be at least 0.',

            'overall_tax_value.numeric' => 'Overall tax value must be a number.',
            'overall_tax_value.min' => 'Overall tax value must be at least 0.',

            'adjustment.numeric' => 'Adjustment must be a number.',
            'adjustment.min' => 'Adjustment must be at least 0.',

            'discount.numeric' => 'Discount must be a number.',
            'discount.min' => 'Discount must be at least 0.',

            'percentage_discount_value.numeric' => 'Percentage discount value must be a number.',
            'percentage_discount_value.min' => 'Percentage discount value must be at least 0.',

            'fixed_discount.numeric' => 'Fixed discount must be a number.',
            'fixed_discount.min' => 'Fixed discount must be at least 0.',

            'subtotal.numeric' => 'Subtotal must be a number.',
            'subtotal.min' => 'Subtotal must be at least 0.',

            'total_tax.numeric' => 'Total tax must be a number.',
            'total_tax.min' => 'Total tax must be at least 0.',

            'total_discount.numeric' => 'Total discount must be a number.',
            'total_discount.min' => 'Total discount must be at least 0.',

            'total.numeric' => 'Total must be a number.',
            'total.min' => 'Total must be at least 0.',

            'created_by.integer' => 'Created by must be an integer.',
        ];
    }
}
