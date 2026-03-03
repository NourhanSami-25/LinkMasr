<?php

use App\Models\user\User;
use App\Models\hr\Department;
use App\Models\hr\Sector;
use App\Models\hr\Position;

use App\Models\client\Client;
use App\Models\task\Task;

use App\Models\project\Project;

if (!function_exists('getUserNameById')) {
    function __getUserNameById($userId): ?string
    {
        $user = User::find($userId);
        $username = $user ? $user->name : null;
        return $username;
    }
}

if (!function_exists('__getUserEmailById')) {

    function __getUserEmailById($userId): ?string
    {
        $user = User::find($userId);
        $email = $user ? $user->email : null;
        return $email;
    }
}

if (!function_exists('__getUsersNamesByIds')) {
    function __getUsersNamesByIds($userIds): string
    {
        $userIds = json_decode($userIds, true);
        if (!is_array($userIds)) {
            return '';
        }
        $users = User::whereIn('id', $userIds)->get();
        $userNames = $users->map(function ($user) {
            return $user->name;
        })->join(' - ');
        return $userNames;
    }
}

if (!function_exists('getDepartmentSubjectById')) {
    function __getDepartmentSubjectById($departmentId): ?string
    {
        $department = Department::find($departmentId);
        $department = $department ? $department->subject : null;
        return $department;
    }
}

if (!function_exists('getPositionSubjectById')) {
    function __getPositionSubjectById($positionId): ?string
    {
        $position = Position::find($positionId);
        $position = $position ? $position->subject : null;
        return $position;
    }
}

if (!function_exists('isManager')) {
    function __isManager($userId): bool
    {
        $isDepartmentManager = Department::where('manager_id', $userId)->exists();
        $isSectorManager = Sector::where('manager_id', $userId)->exists();
        return $isDepartmentManager || $isSectorManager;
    }
}

if (!function_exists('getManagerDepartmentId')) {
    function __getManagerDepartmentId($userId): ?int
    {
        $department = Department::where('manager_id', $userId)->first();
        return $department ? $department->id : null;
    }
}


if (!function_exists('getUsersFromIds')) {
    function __getUsersFromIds(string $jsonIds)
    {
        $userIds = json_decode($jsonIds, true);

        if (!is_array($userIds)) {
            return [];
        }

        $users =  User::whereIn('id', $userIds)->get();
        return $users;
    }
}

if (!function_exists('getUsersFromManyIds')) {
    function __getUsersFromManyIds(...$ids)
    {

        $userIds = [];

        foreach ($ids as $id) {
            if (empty($id)) {
                continue; // Skip null or empty values
            }

            if (is_string($id)) {
                $decoded = json_decode($id, true);
                if (is_array($decoded)) {
                    $userIds = array_merge($userIds, $decoded);
                } else {
                    $userIds[] = $id;
                }
            }
        }

        $userIds = array_filter(array_unique($userIds)); // Remove null, empty, and duplicate values

        return !empty($userIds) ? User::whereIn('id', $userIds)->get() : collect(); // Return empty collection if no valid ID
    }
}


if (!function_exists('getClientsNamesByIds')) {
    function __getClientsNamesByIds($clientIds): string
    {
        $clientIds = json_decode($clientIds, true);
        if (!is_array($clientIds)) {
            return '';
        }
        $clients = Client::whereIn('id', $clientIds)->get();
        $clientNames = $clients->map(function ($client) {
            return $client->name;
        })->join(' - ');
        return $clientNames;
    }
}

if (!function_exists('getClientNameById')) {
    function __getClientNameById($clientId): string
    {
        $client = Client::find($clientId);
        return $client ? $client->name : 'client_not_found';
    }
}

if (!function_exists('getProjectSubjectById')) {
    function __getProjectSubjectById($projectId): string
    {
        $project = Project::find($projectId);
        return $project ? $project->subject : 'project_not_found';
    }
}



if (!function_exists('getProjectSubjectById')) {
    function __getTaskSubjectById($taskId): string
    {
        $task = Task::find($taskId);
        return $task ? $task->subject : 'task_not_found';
    }
}
