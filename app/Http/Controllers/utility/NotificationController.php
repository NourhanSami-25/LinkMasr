<?php

namespace App\Http\Controllers\utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = $this->notificationService->getAll();
        return view('utility.notification.index', compact('notifications'));
    }

    public function getLatestNotifications() // calling by js fetch , depend on route
    {
        $notifications = auth()->user()->notifications;
        return response()->json($notifications);
    }

    public function markAsReadLatest() // calling by js fetch , depend on route
    {
        $response = $this->notificationService->markAsReadLatest();
        return response()->json($response);
    }

    public function markAsRead($id)
    {
        $response = $this->notificationService->markAsRead($id);
        return redirect()->back()->with('success', 'Notification is marked as read successfully');
    }

    public function markAsUnRead($id)
    {
        $response = $this->notificationService->markAsUnRead($id);
        return redirect()->back()->with('success', 'Notification is marked as unread successfully');
    }



    public function markAllAsRead()
    {
        $response = $this->notificationService->markAllAsRead();
        return redirect()->back()->with('success', $response['message']);
    }

    public function delete($id)
    {
        $this->authorize('accesssetting', ['delete']);
        $response = $this->notificationService->delete($id);
        return redirect()->back()->with('success', $response['message']);
    }
}
