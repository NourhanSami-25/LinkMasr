<?php

namespace App\Http\Requests\event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'referable_id'                  => 'nullable|integer',
            'referable_type'                => 'nullable|string|max:255',
            'calendar_event_name'           => 'required|string|max:255',
            'calendar_event_description'    => 'nullable|string|max:5000',
            'calendar_event_location'       => 'nullable|string|max:255',
            'calendar_event_start_date'     => 'required',
            'calendar_event_end_date'       => 'nullable|after:date',
            'calendar_event_start_time'     => 'nullable',
            'calendar_event_end_time'       => 'nullable|after:time',
            'is_allday'                     => 'nullable|boolean',
            'status'                        => 'nullable|string',
            'created_by'                    => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'referable_id.required'                 => 'The associated ID is required.',
            'referable_type.required'               => 'The associated type is required.',
            'calendar_event_name.required'          => 'The subject of the event is required.',
            'calendar_event_name.max'               => 'The subject may not exceed 255 characters.',
            'calendar_event_description.max'        => 'The description may not exceed 5000 characters.',
            'calendar_event_start_date.required'    => 'The event date and time is required.',
            'calendar_event_end_date.after'         => 'The due date must be after the start date.',
            'calendar_event_end_time.after'         => 'The due time must be after the start time.',
            'is_allday.boolean'                     => 'The event all day option must be boolean.',
            'created_by.required'                   => 'The creator ID is required.',
            'created_by.exists'                     => 'The creator must be a valid user.',
        ];
    }
}
