<?php

namespace App\Services\event;

use App\Models\event\Event;
use Illuminate\Support\Facades\Auth;


class EventService
{
    public function getAllEvents()
    {
        return Event::all();
    }

    public function createEvent(array $data)
    {
        $mapping = [
            'calendar_event_name' => 'subject',
            'calendar_event_description' => 'description',
            'calendar_event_location' => 'location',
            'calendar_event_start_date' => 'date',
            'calendar_event_start_time' => 'time',
            'calendar_event_end_date' => 'due_date',
            'calendar_event_end_time' => 'due_time',
        ];

        foreach ($mapping as $formKey => $modelKey) {
            if (isset($data[$formKey])) {
                $data[$modelKey] = $data[$formKey]; // Assign form input value to the corresponding model attribute
                unset($data[$formKey]); // Remove the original form key to avoid passing unnecessary keys
            }
        }

        $data['created_by'] = Auth::id(); // Set created_by to the authenticated user
        $data['referable_type'] = 'App\Models\User'; // Default to User
        $data['referable_id'] = Auth::id();

        return Event::create($data);
    }

    public function getEvent(int $id)
    {
        return Event::findOrFail($id);
    }

    public function updateEvent(Event $event, array $data)
    {

        $mapping = [
            'calendar_event_name' => 'subject',
            'calendar_event_description' => 'description',
            'calendar_event_location' => 'location',
            'calendar_event_start_date' => 'date',
            'calendar_event_start_time' => 'time',
            'calendar_event_end_date' => 'due_date',
            'calendar_event_end_time' => 'due_time',
            'is_allday' => 'is_allday',
        ];

        foreach ($mapping as $formKey => $modelKey) {
            if (isset($data[$formKey])) {
                $data[$modelKey] = $data[$formKey]; // Assign form input value to the corresponding model attribute
                unset($data[$formKey]); // Remove the original form key to avoid passing unnecessary keys
            }
        }

        $data['created_by'] = Auth::id(); // Set created_by to the authenticated user
        $data['referable_type'] = 'App\Models\User'; // Default to User
        $data['referable_id'] = Auth::id();

        $event->update($data);
        return $event;
    }

    public function deleteEvent(Event $event)
    {
        $event->delete();
        return true;
    }
}
