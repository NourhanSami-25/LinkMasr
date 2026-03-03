<?php

namespace App\Services\utility;


use App\Notifications\UserNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;

class NotificationService
{
    public function notify($subject, $message, $url, $users) // this method not exists in controller , just here
    {
        // Ensure $users is a collection
        if (is_a($users, User::class)) {
            $users = collect([$users]); // Single user
        } elseif (is_array($users)) {
            $users = collect($users); // Array of users
        }

        // Notify each user
        $users->each(function ($user) use ($subject, $message, $url): void {
            $user->notify(new UserNotification($subject, $message, $url));
        });
    }

    public function getNotifiedUsers($jsonIds = null, $singleId = null)
    {
        $userIds = collect(); // Always start with a collection

        // Decode JSON safely
        if (!empty($jsonIds)) {
            $decoded = json_decode($jsonIds, true);
            if (is_array($decoded)) {
                $userIds = collect($decoded);
            }
        }

        // Add the creator ID if available
        if (!is_null($singleId)) {
            $userIds->push($singleId);
        }

        // Ensure uniqueness and clean IDs
        $uniqueUserIds = $userIds->filter()->unique()->values();

        // Get users from DB
        return User::whereIn('id', $uniqueUserIds)->get();
    }

    public function getAll()
    {
        $notifications = auth()->user()->notifications;
        return $notifications;
    }

    public function getUnread()
    {
        $unreadNotifications = auth()->user()->unreadNotifications;
        return $unreadNotifications;
    }

    public function getRead()
    {
        $readNotifications = auth()->user()->readNotifications;
        return $readNotifications;
    }

    public function markAsReadLatest()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        foreach ($notifications as $notification) {
            $notification->update(['read_at' => now()]);
        }

        return ['message' => 'Notifications marked as read.'];
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->read_at = now();
        $notification->save();
        return $notification;
    }

    public function markAsUnRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->read_at = Null;
        $notification->save();
        return $notification;
    }


    public function markAllAsRead()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        foreach ($notifications as $notification) {
            $notification->update(['read_at' => now()]);
        }

        return ['success' => true, 'message' => 'All notifications are marked as read successfully'];
    }

    public function delete($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return ['success' => true, 'message' => 'Notification is deleted successfully'];
    }
}
