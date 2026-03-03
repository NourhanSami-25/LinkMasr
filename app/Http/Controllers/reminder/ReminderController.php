<?php

namespace App\Http\Controllers\reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user\User;
use App\Models\reminder\Reminder;
use App\Services\reminder\ReminderService;
use App\Http\Requests\reminder\ReminderRequest;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    protected $reminderService, $reminderFunctionController, $notificationService;


    public function __construct(ReminderService $reminderService, ReminderFunctionController $reminderFunctionController, NotificationService $notificationService)
    {
        $this->reminderService = $reminderService;
        $this->reminderFunctionController = $reminderFunctionController;
        $this->notificationService = $notificationService;
    }


    public function index()
    {
        $reminders = $this->reminderService->getAllRemindersForAuthUser();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('reminder.index', compact('users', 'reminders'));
    }

    public function store(ReminderRequest $request)
    {
        $reminder = $this->reminderService->createReminder($request->validated());
        if ($reminder->members)
            $this->notificationService->notify('Create Reminder:' . $reminder->subject, '', 'none', __getUsersFromIds($reminder->members));
        return redirect()->back()->with('success', 'Reminder created successfully.');
    }

    public function update(ReminderRequest $request, $id)
    {
        $reminder = $this->reminderService->updateReminder($id, $request->validated());
        if ($reminder->members)
            $this->notificationService->notify('Update Reminder:' . $reminder->subject, '', 'none', __getUsersFromIds(json_encode($reminder->members)));
        return redirect()->back()->with('success', 'Reminder updated successfully.');
    }

    public function destroy($id)
    {
        $reminder = $reminder = Reminder::findOrFail($id);
        if ($reminder->members)
            $this->notificationService->notify('Delete Reminder:' . $reminder->subject, '', 'none', __getUsersFromIds($reminder->members));
        $this->reminderService->deleteReminder($id);
        return redirect()->back()->with('success', 'Reminder deleted successfully.');
    }
}
