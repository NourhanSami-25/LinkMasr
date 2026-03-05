<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\setting\Role;
use App\Models\hr\Position;
use App\Models\user\User;
use Exception;

class RoleFunctionController extends Controller
{
    protected static array $permissionLevels = ['view','view_global', 'details', 'create', 'modify', 'delete', 'full'];

    public function users_roles_index()
    {
        $this->authorize('accesssetting', ['view']);
        $users = User::with(['roles' => function ($query) {
            $query->select('roles.id', 'roles.name', 'role_user.access_level');
        }, 'department', 'positionRelation'])->select('id', 'name', 'department_id', 'position_id')->get();
        $positions = Position::select('name')->get();

        return view('setting.role.users_role_index', compact('users', 'positions'));
    }


    public function users_roles_edit($id)
    {
        $this->authorize('accesssetting', ['modify']);
        $user = User::findOrFail($id);
        $roles = Role::all();
        $levels = self::$permissionLevels;

        // Fetch user roles and permissions
        $userPermissions = [];
        foreach ($user->roles as $role) {
            $userPermissions[$role->id] = json_decode($role->pivot->access_level, true) ?? [];
        }

        // Load from config
        $junior_permissions = config('permission_profiles.junior');
        $senior_permissions = config('permission_profiles.senior');
        $manager_permissions = config('permission_profiles.manager');
        $hr_manager_permissions = config('permission_profiles.hr_manager');
        $accountant_permissions = config('permission_profiles.accountant');


        return view('setting.role.users_role_edit', compact('user', 'roles', 'levels', 'userPermissions', 'junior_permissions', 'senior_permissions', 'manager_permissions', 'hr_manager_permissions', 'accountant_permissions'));
    }



    public function users_roles_update(Request $request, $userId)
    {
        try {
            $this->authorize('accesssetting', ['modify']);
            $user = User::findOrFail($userId);
            $existingRoles = $user->roles()->pluck('role_id')->toArray();
            $submittedRoles = $request->roles ?? [];

            // Handle admin role separately
            $adminRole = Role::where('subject', 'admin')->first();
            if ($request->has('admin')) {
                if (!$user->roles()->where('roles.id', $adminRole->id)->exists()) {
                    $user->roles()->attach($adminRole->id, ['access_level' => json_encode(['full'])]);
                }
            } else {
                $user->roles()->detach($adminRole->id);
            }

            // Handle user roles
            $roles = $request->input('roles', []);

            foreach ($roles as $roleId => $permissions) {
                if (!empty($permissions)) {
                    // Convert permissions array to JSON for storage
                    $permissionsJson = json_encode($permissions);

                    // Check if the role-user mapping exists
                    if ($user->roles()->where('role_id', $roleId)->exists()) {
                        $user->roles()->updateExistingPivot($roleId, ['access_level' => $permissionsJson]);
                    } else {
                        $user->roles()->attach($roleId, ['access_level' => $permissionsJson]);
                    }
                }
            }

            // **Handle roles that were NOT in the request** (meaning all checkboxes were unchecked)
            foreach ($existingRoles as $roleId) {
                if (!isset($submittedRoles[$roleId])) {
                    // Remove role completely if no permissions exist
                    $user->roles()->detach($roleId);
                }
            }

            return redirect()->back()->with('success', 'Roles updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error updating roles: ' . $e->getMessage());
        }
    }
}
