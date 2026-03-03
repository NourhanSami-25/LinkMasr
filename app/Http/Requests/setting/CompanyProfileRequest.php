<?php

namespace App\Http\Requests\setting;

use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'business' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1024',
            'type' => 'required|string|max:50',
            'email' => 'required|string|email|max:50',
            'email2' => 'nullable|string|email|max:50',
            'supportEmail' => 'nullable|string|email|max:50',
            'phone' => 'required|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'supportPhone' => 'nullable|string|max:50',
            'country' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'currency' => 'required|string|max:10',
            'city' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:50',
            'pdf_profile' => 'nullable|file|mimes:pdf|max:100400', // 100MB max
            'logo' => 'nullable|file|mimes:jpg,jpeg,png|max:20480', // 2MB max
            'website' => 'nullable|string|max:255',
            'taxNumber' => 'nullable|string|max:50',
            'registrationNumber' => 'nullable|string|max:50',
            'registrationDate' => 'nullable|date',
            'bankAccount' => 'nullable|string|max:255',
            'bankAccount2' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'business.required' => 'The business field is required.',
            'type.required' => 'The type field is required.',
            'email.required' => 'The email field is required.',
            'phone.required' => 'The phone field is required.',
            'country.required' => 'The country field is required.',
            'address.required' => 'The address field is required.',

            'currency.required' => 'The currency field is required.',
            'currency.string' => 'The currency must be a string.',
            'currency.max' => 'The currency may not be greater than 10 characters.',

            'city.string' => 'The city must be a string.',
            'city.max' => 'The city may not be greater than 255 characters.',

            'country_code.string' => 'The country code must be a string.',
            'country_code.max' => 'The country code may not be greater than 255 characters.',

            'zip_code.string' => 'The zip code must be a string.',
            'zip_code.max' => 'The zip code may not be greater than 50 characters.',

            'pdf_profile.file' => 'The PDF profile must be a file.',
            'pdf_profile.mimes' => 'The PDF profile must be a PDF file.',
            'pdf_profile.max' => 'The PDF profile may not be greater than 10MB.',

            'logo.image'  => 'The logo must be an image file.',
            'logo.mimes'  => 'The logo must be a file of type: jpg, jpeg, png.',
            'logo.max'    => 'The logo size must not exceed 2MB.',

            'status.required' => 'The status field is required.',
        ];
    }
}
