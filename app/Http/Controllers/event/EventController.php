<?php

namespace App\Http\Controllers\event;

use App\Http\Requests\event\EventRequest;
use App\Http\Controllers\Controller;
use App\Models\event\Event;
use App\Services\event\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
    public function store(EventRequest $request)
    {
        $this->authorize('accesscalendar', ['create']);
        $event = $this->eventService->createEvent($request->validated());
        return redirect()->route('calendar.index')->with('success', 'Event created successfully.');
    }

    public function update(EventRequest $request, $id)
    {
        $this->authorize('accesscalendar', ['modify']);
        $event = $this->eventService->getEvent($request->event_id);
        if (!$event) {
            return redirect()->back();
        }

        $updatedEvent = $this->eventService->updateEvent($event, $request->validated());
        return redirect()->route('calendar.index')->with('success', 'Event Updated successfully.');
    }

    // public function destroy($id)
    // {
    //     $this->authorize('accesscalendar', ['delete']);
    //     $event = $this->eventService->getEvent($id);
    //     $this->eventService->deleteEvent($event);
    //     return redirect()->route('calendar.index')->with('success', 'Event deleted successfully.');
    // }

    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
