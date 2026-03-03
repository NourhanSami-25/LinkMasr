<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\setting\Role;
use App\Services\setting\RoleService;
use App\Http\Requests\setting\RoleRequest;

use Exception;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $this->authorize('accesssetting', ['view']);
        $roles = $this->roleService->getAll();
        return view('setting.role.index', compact('roles'));
    }


    public function create()
    {
        $this->authorize('accesssetting', ['create']);
        return view('setting.role.create');
    }


    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleService->create($request->validated());
            return redirect()->route('roles.index')->with('success', 'Role Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        // $this->authorize('accesshr', ['details']);
    }



    public function edit($id)
    {
        $this->authorize('accesssetting', ['modify']);
        $role = Role::findOrFail($id);
        return view('setting.role.edit', compact('role'));
    }



    public function update(RoleRequest $request, $id)
    {
        try {
            $role = $this->roleService->update($id, $request->validated());
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesssetting', ['delete']);
            $this->roleService->delete($id);
            return redirect()->route('roles.index')->with('success', 'Role Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
