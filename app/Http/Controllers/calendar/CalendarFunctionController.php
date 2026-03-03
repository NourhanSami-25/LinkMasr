<?php

namespace App\Http\Controllers\calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\event\Event;
use App\Models\reminder\Reminder;
use App\Models\project\Project;


use App\Models\business\Contract;
use App\Models\finance\PaymentRequest;
use App\Models\task\Task;
use Carbon\Carbon;
use Exception;


class CalendarFunctionController extends Controller
{


    public function getFilteredCalendarEvents($requiredEvents)
    {
        $allEvents = collect();

        // Define available event methods
        $eventMethods = [
            'projects' => 'getProjects',
            'tasks' => 'getTasks',
       
            'paymentRequests' => 'getPaymentRequests',
            'contracts' => 'getContracts',
            'reminders' => 'getReminders',
            'events' => 'getEvents'
        ];

        // Loop through required events and only fetch those
        foreach ($requiredEvents as $eventType) {
            if (array_key_exists($eventType, $eventMethods)) {
                $method = $eventMethods[$eventType];

                // Merge the result of each selected method
                $allEvents = $allEvents->merge($this->$method());
            }
        }

        return response()->json($allEvents);
    }


    public function getCalendarEvents()
    {
        $authUser = auth()->user();
    
        // 1️⃣ If admin → allow all sections
        if ($authUser->isAdmin()) {
            return $this->getFilteredCalendarEvents([
                'projects', 'tasks','paymentRequests', 'contracts', 'reminders', 'events'
            ]);
        }
    
        // 2️⃣ If not admin → check per permission
        $sections = [
            'projects'           => 'project',
            'tasks'              => 'task',
            'paymentRequests'    => 'finance',
            'contracts'          => 'contract',
            'reminders'          => 'reminder',
            'events'             => 'event',
        ];
    
        $allowed = [];
    
        foreach ($sections as $key => $permission) {
            if (
                $authUser->hasAccess($permission, 'full') ||
                $authUser->hasAccess($permission, 'view') ||
                $authUser->hasAccess($permission, 'view_global')
            ) {
                $allowed[] = $key;
            }
        }
    
        return $this->getFilteredCalendarEvents($allowed);
    }



    private function getProjects()
    {
        try {
            return Project::with('client:id,name')->select('id', 'subject', 'description', 'date', 'due_date','assignees','client_id','status')
                ->where('created_by', auth()->id())
                ->orWhereJsonContains('assignees', (string) auth()->id())
                ->get()
                ->map(fn ($project) => [
                    'id'    => $project->id,
                    'title' => $project->subject. ' ' . '( ' .($project->client?->name ?? 'No Client'). ' )'. ' ' . '( ' . __getUsersNamesByIds($project->assignees) . ' )',
                    'start' => Carbon::parse($project->date)->format('Y-m-d\TH:i:s'),
                    'end'   => $project->due_date ? Carbon::parse($project->due_date)->format('Y-m-d\TH:i:s') : Carbon::parse($project->date)->format('Y-m-d\TH:i:s'),
                    'description' => $project->description,
                    'className'   => 'border-success bg-success text-inverse-success',
                    'location'    => __("general.{$project->status}") ,
                    'type'        => 'project',
                    'event_url'    => route('projects.show', $project->id),
                ]);
        } catch (Exception $e) {
            return collect(); // Return empty collection if there's an error
        }
    }

    private function getTasks()
    {
        try {
            return Task::with('client:id,name')->select('id', 'subject', 'description', 'date', 'due_date','assignees','client_id', 'status')
                ->where('created_by', auth()->id())
                ->orWhereJsonContains('assignees', (string) auth()->id())
                ->orWhereJsonContains('followers', (string) auth()->id())
                ->get()
                ->map(fn ($task) => [
                    'id'    => $task->id,
                    'title' => $task->subject. ' ' . '( ' .($task->client?->name ?? 'No Client'). ' )'. ' ' . '( ' . __getUsersNamesByIds($task->assignees) . ' )',
                    'start' => Carbon::parse($task->date)->format('Y-m-d'),
                    'end'   => $task->due_date ? Carbon::parse($task->due_date)->format('Y-m-d') : Carbon::parse($task->date)->format('Y-m-d'),
                    'description' => $task->description,
                    'className'   => 'border-light bg-primary bg-opacity-70',
                    'location'    => __("general.{$task->status}") ,
                    'type'        => 'task',
                    'event_url'    => route('tasks.show', $task->id),
                ]);
        } catch (Exception $e) {
            return collect();
        }
    }

    private function getPaymentRequests()
    {
        try {
            return PaymentRequest::select('id', 'number', 'description', 'date', 'due_date' , 'client_name' , 'total' , 'currency')
                ->get()
                ->map(fn ($paymentRequest) => [
                    'id'    => $paymentRequest->id,
                    'title' => 'Payment Request #' . $paymentRequest->number . ' ( ' . $paymentRequest->client_name . ' ) ',
                    'start' => Carbon::parse($paymentRequest->date)->format('Y-m-d'),
                    'end'   => $paymentRequest->due_date ? Carbon::parse($paymentRequest->due_date)->format('Y-m-d') : Carbon::parse($paymentRequest->date)->format('Y-m-d'),
                    'description' => $paymentRequest->total . ' ' . $paymentRequest->currency,
                    'className'   => 'border-info bg-info text-inverse-info',
                    'location'    => $paymentRequest->description,
                    'type'        => 'paymentRequest',
                    'event_url'    => route('paymentRequests.show', $paymentRequest->id),
                ]);
        } catch (Exception $e) {
            return collect();
        }
    }

    private function getContracts()
    {
        try {
            return Contract::select('id', 'subject', 'description', 'date', 'due_date' ,'client_name', 'total' , 'currency')
                ->get()
                ->map(fn ($contract) => [
                    'id'    => $contract->id,
                    'title' => $contract->subject. ' ( ' . $contract->client_name . ' ) ',
                    'start' => Carbon::parse($contract->date)->format('Y-m-d'),
                    'end'   => $contract->due_date ? Carbon::parse($contract->due_date)->format('Y-m-d') : Carbon::parse($contract->date)->format('Y-m-d'),
                    'description' => $contract->total . ' ' . $contract->currency,
                    'className'   => 'border-danger bg-danger text-inverse-danger',
                    'location'    => $contract->description,
                    'type'        => 'contract',
                    'event_url'    => route('contracts.show', $contract->id),
                ]);
        } catch (Exception $e) {
            return collect();
        }
    }

    private function getReminders()
    {
        try {
            return Reminder::select('id', 'subject', 'date','status')
                ->where('created_by', auth()->id())
                ->orWhereJsonContains('members', (string) auth()->id())
                ->get()
                ->map(fn ($reminder) => [
                    'id'    => $reminder->id,
                    'title' => $reminder->subject,
                    'start' => Carbon::parse($reminder->date)->format('Y-m-d'),
                    'end'   => Carbon::parse($reminder->date)->format('Y-m-d'),
                    'description' => $reminder->subject,
                    'className'   => 'border-light bg-success',
                    'location'    => __("general.{$reminder->status}") ,
                    'type'        => 'reminder',
                ]);
        } catch (Exception $e) {
            return collect();
        }
    }

    private function getEvents()
    {
        try {
            return Event::select('id', 'subject', 'description', 'due_date', 'date', 'location', 'is_allday', 'time', 'due_time','created_at')
                ->where('created_by', auth()->id())
                ->get()
                ->map(function ($event) {
                    $startDate = Carbon::parse($event->date);
                    $endDate = $event->due_date ? Carbon::parse($event->due_date) : $startDate->copy();
                    
                    // Format start and end dates
                    $start = $event->is_allday 
                        ? $startDate->format('Y-m-d')
                        : $startDate->format('Y-m-d') . 'T' . ($event->time ?: '00:00:00');
                    
                    $end = $event->is_allday
                        ? $endDate->format('Y-m-d')
                        : $endDate->format('Y-m-d') . 'T' . ($event->due_time ?: '23:59:59');
                    
                    return [
                        'id'          => $event->id,
                        'title'       => $event->subject,
                        'start'       => $start,
                        'end'         => $end,
                        'description' => $event->description,
                        'className'   => 'border-light bg-dark text-inverse-dark',
                        'location'    => __("general.created_at") . ' : ' . $event->created_at->format('Y-m-d'),
                        'type'        => 'event',
                        'allDay'      => (bool)$event->is_allday, // Add allDay property for FullCalendar
                    ];
                });
        } catch (Exception $e) {
            return collect();
        }
    }
}
