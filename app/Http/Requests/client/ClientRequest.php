<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'id' => 'nullable',
            'type' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{5,20}$/|max:20',
            'email' => 'required|email|max:50',
            'currency' => 'required|string|max:10',
            'default_language' => 'required|string|max:20',
            'status' => 'required|string|max:20',
            'created_by' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bio' => 'nullable|max:1024',
            'phone2' => 'nullable|max:50',
            'website' => 'nullable|max:255',
            'tax_number' => 'nullable|max:50',
            'computer_number' => 'nullable|max:50',
        ];
    }

    public function messages()
    {
        return [
            'type.string' => 'The client type must be a string.',
            'type.max' => 'The client type may not be greater than 255 characters.',
            'name.required' => 'The Name is required.',
            'name.string' => 'The Name must be a string.',
            'name.max' => 'The Name must not exceed 50 characters.',
            'phone.required' => 'The Phone is required.',
            'phone.string' => 'The Phone must be a string.',
            'phone.max' => 'The Phone must be between 5 and 20 digits.',
            'email.required' => 'The Email is required.',
            'email.email' => 'The Email must be a valid email address.',
            'email.max' => 'The Email must not exceed 50 characters.',
            'email.unique' => 'The Email has already been taken.',
            'currency.required' => 'The Currency is required.',
            'currency.string' => 'The Currency must be a string.',
            'currency.max' => 'The Currency must not exceed 10 characters.',
            'default_language.required' => 'The Default Language is required.',
            'default_language.max' => 'The defaultLanguage must not exceed 50 characters.',
            'status.required' => 'The Status is required.',
            'status.max' => 'The status must not exceed 50 characters.',
            'photo.image' => 'The photo must be an image file.',
            'photo.mimes' => 'The photo must be a file of type: jpg, jpeg, png.',
            'photo.max' => 'The photo size must not exceed 2MB.',
            'bio.max' => 'The bio must not exceed 1024 characters.',
            'phone2.max' => 'The phone2 number must not exceed 50 characters.',
            'website.max' => 'The website must not exceed 255 characters.',
            'tax_number.max' => 'The Tax Number must not exceed 50 characters.',
            'computer_number.max' => 'The Computer Number must not exceed 50 characters.',
        ];
    }
}
