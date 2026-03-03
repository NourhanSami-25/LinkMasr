<?php

namespace App\Services\setting;


use App\Models\setting\Role;

class RoleService
{
    public function getAll()
    {
        return Role::all();
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }
}
