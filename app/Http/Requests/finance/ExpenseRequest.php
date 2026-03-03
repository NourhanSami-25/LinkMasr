<?php

namespace App\Http\Requests\finance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseRequest extends FormRequest
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
        $expenseId = $this->route('expense');

        return [
            'project_id' => 'nullable|integer',
            'task_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'client_name' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string|max:255',

            'number' => [
                'required',
                'integer',
                $isUpdate
                    ? Rule::unique('expenses', 'number')->ignore($expenseId)
                    : 'unique:expenses,number',
            ],

            'is_repeated'         => 'nullable|boolean',
            'repeat_every'        => 'nullable|string|max:10',
            'repeat_counter'      => 'nullable|integer|min:0',

            'type'                => 'required|string|max:100',
            'date'                => 'required|date',
            'currency'            => 'required|string|max:10',
            'sale_agent'          => 'nullable|string|max:50',

            'status'              => 'nullable|string|max:50',
            'description'         => 'required|string|max:1024',
            'client_note'         => 'nullable|string|max:1024',

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

            'payment_method'      => 'nullable|string|max:10',
            'have_package'        => 'required|boolean',
            'package_date'        => 'nullable|date',
            'package_number'      => 'nullable|string|max:10',
            'total_balance'       => 'nullable|numeric|min:0',

            'created_by'          => 'nullable|exists:users,id',
            'attachments'         => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            // Project & Task & Client
            'project_id.integer' => 'Project ID must be an integer.',
            'task_id.integer' => 'Task ID must be an integer.',
            'client_id.integer' => 'Client ID must be an integer.',

            // Client details
            'client_name.string' => 'Client name must be a string.',
            'client_name.max' => 'Client name cannot exceed 255 characters.',
            'billing_address.string' => 'Billing address must be a string.',
            'billing_address.max' => 'Billing address cannot exceed 255 characters.',

            // Main expense data
            'number.required' => 'Expense number is required.',
            'number.integer' => 'Expense number must be an integer.',
            'number.unique' => 'This expense number is already in use.',

            'is_repeated.boolean' => 'Repeat status must be true or false.',
            'repeat_every.string' => 'Repeat every must be a string.',
            'repeat_every.max' => 'Repeat every cannot exceed 10 characters.',
            'repeat_counter.integer' => 'Repeat counter must be an integer.',
            'repeat_counter.min' => 'Repeat counter must be at least 0.',

            'type.required' => 'Expense type is required.',
            'type.string' => 'Expense type must be a string.',
            'type.max' => 'Expense type cannot exceed 100 characters.',

            'date.required' => 'Expense date is required.',
            'date.date' => 'Expense date must be a valid date.',

            'currency.required' => 'Currency is required.',
            'currency.string' => 'Currency must be a string.',
            'currency.max' => 'Currency cannot exceed 10 characters.',

            'sale_agent.string' => 'Sale agent must be a string.',
            'sale_agent.max' => 'Sale agent cannot exceed 50 characters.',

            'status.string' => 'Status must be a string.',
            'status.max' => 'Status cannot exceed 50 characters.',

            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',
            'description.max' => 'Description cannot exceed 1024 characters.',

            'client_note.string' => 'Client note must be a string.',
            'client_note.max' => 'Client note cannot exceed 1024 characters.',

            // Financial fields
            'discount_type.string' => 'Discount type must be a string.',
            'discount_type.max' => 'Discount type cannot exceed 50 characters.',
            'discount_amount_type.string' => 'Discount amount type must be a string.',
            'discount_amount_type.max' => 'Discount amount type cannot exceed 50 characters.',
            'tax.string' => 'Tax must be a string.',
            'tax.max' => 'Tax cannot exceed 255 characters.',

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

            // Payment & Package
            'payment_method.string' => 'Payment method must be a string.',
            'payment_method.max' => 'Payment method cannot exceed 10 characters.',
            'have_package.required' => 'Have package field is required.',
            'have_package.boolean' => 'Have package must be true or false.',
            'package_date.date' => 'Package date must be a valid date.',
            'package_number.string' => 'Package number must be a string.',
            'package_number.max' => 'Package number cannot exceed 10 characters.',
            'total_balance.numeric' => 'Total balance must be a number.',
            'total_balance.min' => 'Total balance must be at least 0.',

            // Creator
            'created_by.exists' => 'The selected user does not exist.',
        ];
    }
}
