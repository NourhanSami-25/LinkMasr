<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'client_id'       => 'required|exists:clients,id',
            'country'         => 'required|string|max:50',
            'state'           => 'nullable|string|max:50',
            'city'            => 'required|string|max:50',
            'street_name'     => 'required|string|max:50',
            'street_number'   => 'nullable|string|max:10',
            'building_number' => 'nullable|string|max:10',
            'floor_number'    => 'nullable|string|max:10',
            'unit_number'     => 'nullable|string|max:10',
            'zip_code'        => 'nullable|string|max:10',
            'status'          => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required'       => 'The client ID is required.',
            'client_id.exists'         => 'The selected client ID is invalid.',
            'country.required'         => 'The country field is required.',
            'country.max'              => 'The country name cannot exceed 50 characters.',
            'state.max'                => 'The state name cannot exceed 50 characters.',
            'city.required'            => 'The city field is required.',
            'city.max'                 => 'The city name cannot exceed 50 characters.',
            'street_name.required'     => 'The street name field is required.',
            'street_name.max'          => 'The street name cannot exceed 50 characters.',
            'street_number.max'        => 'The street number cannot exceed 10 characters.',
            'building_number.max'      => 'The building number cannot exceed 10 characters.',
            'floor_number.max'         => 'The floor number cannot exceed 10 characters.',
            'unit_number.max'          => 'The unit number cannot exceed 10 characters.',
            'zip_code.max'             => 'The zip code cannot exceed 10 characters.',
            'status.required'          => 'The status field is required.',
            'status.in'                => 'The status must be either active or inactive.',
        ];
    }
}
