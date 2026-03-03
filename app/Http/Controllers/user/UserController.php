<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\Department;
use App\Models\hr\Position;
use App\Models\hr\Balance;
use App\Models\setting\Role;
use App\Models\user\User;
use App\Services\user\UserService;
use App\Http\Requests\user\UserRequest;
use App\Services\hr\BalanceService;
use Exception;

class UserController extends Controller
{

    protected $userService, $userFunctionController, $permissionLevels, $balanceService;


    public function __construct(UserService $userService, UserFunctionController $userFunctionController, BalanceService $balanceService)
    {
        $this->userService = $userService;
        $this->userFunctionController = $userFunctionController;
        $this->permissionLevels = ['view', 'view_global', 'details', 'create', 'modify', 'delete', 'full'];
        $this->balanceService = $balanceService;
    }

    public function index()
    {
        // $this->authorize('accessuser', ['view']);
        $users = $this->userService->getAll()->reverse();
        return view('user.index', compact('users'));
    }


    public function create()
    {
        // $this->authorize('accessuser', ['create']);
        $departments = Department::select('id', 'name as subject')->get();
        $positions = Position::select('id', 'name as subject')->get();
        $roles = Role::all();
        $levels = $this->permissionLevels;
        $emails = User::pluck('email')->toArray();

        // Load from config
        $junior_permissions = config('permission_profiles.junior');
        $senior_permissions = config('permission_profiles.senior');
        $manager_permissions = config('permission_profiles.manager');
        $hr_manager_permissions = config('permission_profiles.hr_manager');
        $accountant_permissions = config('permission_profiles.accountant');

        return view('user.create', compact('departments', 'positions', 'roles', 'levels', 'emails', 'junior_permissions', 'senior_permissions', 'manager_permissions', 'hr_manager_permissions', 'accountant_permissions'));
    }


    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->create($request->validated());
            $this->userFunctionController->assign_user_permissions($request, $user);
            $this->userService->afterUserStored($user, $request->plain_password);

            if ($request->filled('total_days')) {
                $this->balanceService->create([
                    'user_id' => $user->id,
                    'year' => now()->year,
                    'total_days' => (int) $request->input('total_days'),
                    'used_days' => 0,
                ]);
            }

            // Redirect to show the user data page
            return redirect()->route('user.showData');

        } catch (Exception $e) {
            // Handle error - user won't see the data page
            return back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }


    public function showUserData()
    {
        $data = session('new_user_data');
        if (!$data) {
            abort(403, 'Please Fill Data Correctly');
        }
        return view('user._created_status', ['data' => $data]);
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        $balance = $user->balance;
        $authUser = auth()->user();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        if ($authUser->isAdmin() || $authUser->id == $id || $authUser->hasAccess('user', 'details')) {
            $projects = $this->userFunctionController->getProjects($id);
            $tasks = $this->userFunctionController->getTasks($id);

            $reminders = $this->userFunctionController->getReminders($id);
            $requests = $this->userFunctionController->getRequests($id);
            $todos = $this->userFunctionController->getTodos($id);

            return view('user.show', compact('user', 'balance', 'users', 'projects', 'tasks', 'reminders', 'requests', 'todos'));
        }
    }



    public function edit($id)
    {
        // $this->authorize('accessuser', ['modify']);
        $user = User::findOrFail($id);
        $departments = Department::select('id', 'name as subject')->get();
        $positions = Position::select('id', 'name as subject')->get();
        $roles = Role::select('id', 'name as subject')->get();
        return view('user.edit', compact('user', 'departments', 'positions', 'roles'));
    }



    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->userService->update($id, $request->validated());

            if ($request->filled('total_days')) {
                Balance::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'year' => now()->year
                    ],
                    [
                        'total_days' => (int) $request->input('total_days'),
                        'used_days' => 0
                    ]
                );
            }

            return redirect()->route('users.show', $user->id)->with('success', 'User Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            // $this->authorize('accessuser', ['delete']);
            $this->userService->delete($id);
            return redirect()->route('users.index')->with('success', 'User Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
