<?php

namespace App\Services\reminder;

use App\Models\reminder\Reminder;
use App\Models\user\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class ReminderService
{

    public function getAllRemindersForAuthUser()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('reminder', 'full') || $authUser->hasAccess('reminder', 'view_global')) {
            return Reminder::all();
        }
        else
        {
            $authId = Auth::id();
            // Get reminders where referable_type = User & referable_id = Auth::id()
            $reminders1 = Reminder::where('referable_type', 'App\Models\user\User')
                ->where('referable_id', $authId)
                ->get();
            
            // Get reminders where created_by = Auth::id()
            $reminders2 = Reminder::where('created_by', $authId)->get();
            
            // Get reminders where Auth::id() is in "assigned_to" JSON array
            $reminders3 = Reminder::whereJsonContains('assigned_to', (string) $authId)->get();
            
            // Merge results and remove duplicates
            $allReminders = $reminders1
                ->merge($reminders2)
                ->merge($reminders3)
                ->unique('id') // Ensure no duplicate reminders
                ->sortByDesc(function ($reminder) {
                    return [$reminder->priority === 'urgent' ? 1 : 0, $reminder->created_at];
                });
            return $allReminders;
        }
    }

    // Create a new reminder
    public function createReminder($data)
    {
        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id(); // Set user_id to current authenticated user
        
        // Set default assigned_to if not provided
        if (!isset($data['assigned_to']) || empty($data['assigned_to'])) {
            $data['assigned_to'] = json_encode([Auth::id()]);
        } elseif (is_array($data['assigned_to'])) {
            $data['assigned_to'] = json_encode($data['assigned_to']);
        }
        
        // Set default description if not provided
        if (!isset($data['description']) || empty($data['description'])) {
            $data['description'] = $data['subject'] ?? 'تنبيه جديد';
        }
        
        // Handle members field - map it to assigned_to if provided
        if (!empty($data['members'])) {
            if (is_array($data['members'])) {
                $data['assigned_to'] = json_encode($data['members']);
            } else {
                $data['assigned_to'] = $data['members'];
            }
            // Remove members from data since it doesn't exist in the table
            unset($data['members']);
        }
        
        return Reminder::create($data);
    }


    // Update a reminder
    public function updateReminder($id, $data)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->update($data);
        return $reminder;
    }

    // Delete a reminder
    public function deleteReminder($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();
    }
}
