<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'department_id' => 'required|integer|max:255',
            'position_id' => 'required|integer|max:255',
            'status' => 'required|string|max:255',
            'password' => $isUpdate ? 'nullable|string|min:10|max:16' : 'required|string|min:10|max:16',
            'bio' => 'nullable|max:2048',
            'phone' => 'nullable|max:50',
            'address' => 'nullable|max:255',
            'linkedin' => 'nullable|max:255',
            'facebook' => 'nullable|max:255',
            'signature' => 'nullable|max:255',
            'hourly_rate' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'job_title' => 'nullable|max:50',
            'language' => 'nullable',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 50 characters. ',

            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
            'status.max' => 'The status must not exceed 50 characters. ',

            'password.min' => 'The password must be 10 digits or more',
            'password.max' => 'The password must not exceed 16 characters.',

            'bio.max' => 'The bio must not exceed 1024 characters.',
            'phone.max' => 'The phone number must not exceed 50 characters.',
            'address.max' => 'The address must not exceed 255 characters.',
            'linkedin.max' => 'The LinkedIn profile link must not exceed 255 characters.',
            'facebook.max' => 'The Facebook profile link must not exceed 255 characters.',
            'signature.max' => 'The signature must not exceed 255 characters.',
            'hourly_rate.nullable' => 'The hourly rate is optional.',
            'photo.image' => 'The photo must be an image file.',
            'photo.mimes' => 'The photo must be a file of type: jpg, jpeg, png.',
            'photo.max' => 'The photo size must not exceed 2MB.',
            'job_title.max' => 'The job title must not exceed 50 characters.',
            'position.max' => 'The position must not exceed 50 characters.',
        ];
    }
}
