<?php

namespace App\Services\task;

use App\Models\task\Task;
use App\Models\user\User;
use Illuminate\Support\Facades\Auth;


class TaskService
{
    public function getAll()
    {
        $authUser = auth()->user();
        $userId = $authUser->id;

        // Check global access first
        if ($authUser->isAdmin() || $authUser->hasAccess('task', 'full') || $authUser->hasAccess('task', 'view_global')) {
            $tasks = Task::all();
        } else {
            // Base query for user's tasks
            $tasksQuery = Task::where('created_by', $userId)
                ->orWhereJsonContains('followers', (string) $userId)
                ->orWhereJsonContains('assignees', (string) $userId);

            // Manager-specific access
            if (__isManager($userId)) {
                $departmentId = __getManagerDepartmentId($userId);
                $departmentUserIds = User::where('department_id', $departmentId)->pluck('id');

                $tasksQuery->orWhereIn('created_by', $departmentUserIds)
                    ->orWhere(function ($query) use ($departmentUserIds) {
                        foreach ($departmentUserIds as $id) {
                            $query->orWhereJsonContains('followers', (string) $id)
                                  ->orWhereJsonContains('assignees', (string) $id);
                        }
                    });
            }

            // Execute query
            $tasks = $tasksQuery->distinct()->get();
        }

        // Eager load assignees and followers names (more efficient)
        $userIds = collect();
        $tasks->each(function ($task) use (&$userIds) {
            $assignees = is_string($task->assignees) ? json_decode($task->assignees, true) : $task->assignees;
            $followers = is_string($task->followers) ? json_decode($task->followers, true) : $task->followers;
            
            $userIds = $userIds->merge($assignees ?? [])
                              ->merge($followers ?? []);
        });

        $users = User::whereIn('id', $userIds->unique())->pluck('name', 'id');

        // Map names to tasks
        $tasks->each(function ($task) use ($users) {
            $assignees = is_string($task->assignees) ? json_decode($task->assignees, true) : $task->assignees;
            $followers = is_string($task->followers) ? json_decode($task->followers, true) : $task->followers;
            
            $task->assignees_names = isset($task->assignees) 
                ? array_filter(array_map(fn($id) => $users[$id] ?? null, $assignees ?? []))
                : [];

            $task->followers_names = isset($task->followers) 
                ? array_filter(array_map(fn($id) => $users[$id] ?? null, $followers ?? []))
                : [];
        });

        return $tasks;
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        if (!empty($data['assignees'])) {
            $data['assignees'] = json_encode($data['assignees']);
        }
        if (!empty($data['followers'])) {
            $data['followers'] = json_encode($data['followers']);
        }
        $task = new Task();
        $task->fill($data);
        $task->save();
        return $task;
    }

    public function getItemById($id)
    {
        $task = Task::findOrFail($id);
        return $task;
    }

    public function update($id, array $data)
    {
        $task = Task::findOrFail($id);

        // Ensure keys exist in the array before using them
        $task->assignees = json_encode($data['assignees'] ?? []);
        $task->followers = json_encode($data['followers'] ?? []);

        $task->update($data);

        return $task;
    }


    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}
