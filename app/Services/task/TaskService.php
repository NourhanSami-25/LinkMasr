<?php

namespace App\Services\task;

use App\Models\task\Task;
use App\Models\user\User;
use Illuminate\Support\Facades\Auth;


class TaskService
{
    public function getAll()
    {
        // Temporarily return all tasks for testing
        $tasks = Task::all();

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
        
        // Map 'date' field to 'start_date' for database compatibility
        if (isset($data['date'])) {
            $data['start_date'] = $data['date'];
            unset($data['date']);
        }
        
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

        // Map 'date' field to 'start_date' for database compatibility
        if (isset($data['date'])) {
            $data['start_date'] = $data['date'];
            unset($data['date']);
        }

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
