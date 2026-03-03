<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\Department;
use App\Models\hr\Position;
use App\Models\setting\Role;
use App\Models\hr\Sector;
use App\Models\user\User;
use App\Services\hr\DepartmentService;
use App\Http\Requests\hr\DepartmentRequest;
use Illuminate\Http\Request;
use Exception;


class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $this->authorize('accesshr', ['view']);
        $departments = $this->departmentService->getAll()->reverse();
        return view('hr.department.index', compact('departments'));
    }


    public function create()
    {
        $this->authorize('accesshr', ['create']);
        $sectors = Sector::select('id', 'subject')->get();
        $departments = Department::select('id', 'subject')->get();
        $positions = Position::select('id', 'subject')->get();
        $roles = Role::select('id', 'subject')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('hr.department.create', compact('sectors', 'departments', 'positions', 'roles', 'users'));
    }


    public function store(DepartmentRequest $request)
    {
        try {
            $department = $this->departmentService->create($request->validated());
            return redirect()->route('departments.index')->with('success', 'Department Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesshr', ['details']);
        $department = Department::findOrFail($id);
        return view('hr.department.show', compact('department'));
    }



    public function edit($id)
    {
        $this->authorize('accesshr', ['modify']);
        $sectors = Sector::select('id', 'subject')->get();
        $department = Department::findOrFail($id);
        $departments = Department::select('id', 'subject')->get();
        $positions = Position::select('id', 'subject')->get();
        $roles = Role::select('id', 'subject')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('hr.department.edit', compact('sectors', 'department', 'departments', 'positions', 'roles', 'users'));
    }



    public function update(DepartmentRequest $request, $id)
    {
        try {
            $department = $this->departmentService->update($id, $request->validated());
            return redirect()->route('departments.index')->with('success', 'Department updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesshr', ['delete']);
            $this->departmentService->delete($id);
            return redirect()->route('departments.index')->with('success', 'Department Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
