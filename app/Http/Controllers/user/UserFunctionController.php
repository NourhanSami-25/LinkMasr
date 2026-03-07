<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\setting\Role;
use App\Models\user\User;

use App\Models\project\Project;
use App\Models\task\Task;


use App\Models\reminder\Reminder;
use App\Models\utility\Todo;

use App\Models\request\MissionRequest;
use App\Models\request\MoneyRequest;
use App\Models\request\OvertimeRequest;
use App\Models\request\PermissionRequest;
use App\Models\request\WorkhomeRequest;
use App\Models\request\VacationRequest;
use App\Models\request\SupportRequest;

use Illuminate\Support\Facades\Auth;

class UserFunctionController extends Controller
{

    protected $models = [
        'mission' => MissionRequest::class,
        'money' => MoneyRequest::class,
        'overtime' => OvertimeRequest::class,
        'permission' => PermissionRequest::class,
        'workhome' => WorkhomeRequest::class,
        'vacation' => VacationRequest::class,
        'support' => SupportRequest::class,
    ];

    public function getProjects($userId)
    {
        $projects = Project::where('created_by', $userId)
            ->orWhereJsonContains('assignees', (string) $userId)
            ->distinct()
            ->get();
        return $projects;
    }



    public function getTasks($userId)
    {
        $tasks = Task::where('created_by', $userId)
            ->orWhereJsonContains('assignees', (string) $userId)
            ->orWhereJsonContains('followers', (string) $userId)
            ->distinct()
            ->get();
        return $tasks;
    }



    public function getReminders($userId)
    {
        $reminders = Reminder::where('created_by', $userId)
            ->orWhere('referable_type', 'App\Models\user\User' && 'referable_id', $userId)
            ->distinct()
            ->get();
        return $reminders;
    }


    public function getTodos($userId)
    {
        $todos = Todo::where('user_id', $userId)->get();
        return $todos;
    }

    public function getRequests($userId)
    {
        $allRequests = collect();
        foreach ($this->models as $type => $model) {
            try {
                $requests = $model::where('user_id', $userId)
                    ->orWhere(function($query) use ($userId) {
                        $query->whereJsonContains('follower', (string) $userId)
                              ->orWhereJsonContains('handover', (string) $userId);
                    })
                    ->distinct()
                    ->get()
                    ->map(function ($request) use ($type) {
                        return $request->setAttribute('type', $type);
                    });
                $allRequests = $allRequests->merge($requests);
            } catch (\Exception $e) {
                // Skip this model if there's a JSON error and continue with others
                continue;
            }
        }
        $requests = $allRequests->sortByDesc('created_at');
        return $requests;
    }

    public function assign_user_permissions($request, $user)
    {
        // ✅ Handle Admin Role
        $adminRole = Role::where('subject', 'admin')->first();
        if ($request->has('admin')) {
            $user->roles()->attach($adminRole->id, ['access_level' => json_encode(['full'])]);
        } else {
            // Remove admin role if unchecked
            $user->roles()->detach($adminRole->id);
        }

        // ✅ Assign Other Roles
        if ($request->has('roles')) {
            foreach ($request->roles as $roleId => $permissions) {
                if (!empty($permissions)) {
                    // Convert selected permissions to JSON format
                    $permissionsJson = json_encode($permissions);

                    // Check if the role-user mapping exists
                    if ($user->roles()->where('role_id', $roleId)->exists()) {
                        $user->roles()->updateExistingPivot($roleId, ['access_level' => $permissionsJson]);
                    } else {
                        $user->roles()->attach($roleId, ['access_level' => $permissionsJson]);
                    }
                } else {
                    // If no permissions are selected, remove the role from the user
                    $user->roles()->detach($roleId);
                }
            }
        }
    }

    public function disable($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'disabled';
        $user->save();
        return redirect()->back()->with('success', 'User is disabled successfully');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return redirect()->back()->with('success', 'User is activated successfully');
    }

    public function default_lang($lang)
    {
        if (!in_array($lang, ['en', 'ar'])) {
            abort(400, 'Invalid language selection.');
        }

        session(['app_locale' => $lang]);

        if (auth()->check()) {
            $user = User::findOrFail(auth()->id());
            $user->language = $lang;
            $user->save();
        }

        return redirect()->back();
    }
}
