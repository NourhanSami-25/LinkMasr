<?php

namespace App\Services\hr;


use App\Models\hr\Department;

class DepartmentService
{
    public function getAll()
    {
        return Department::all();
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update($id, $data)
    {
        $department = Department::findOrFail($id);
        $department->update($data);
        return $department;
    }

    public function delete($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
    }
}
