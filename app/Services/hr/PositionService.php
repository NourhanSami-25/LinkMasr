<?php

namespace App\Services\hr;


use App\Models\hr\Position;

class PositionService
{
    public function getAll()
    {
        return Position::all();
    }

    public function create(array $data)
    {
        return Position::create($data);
    }

    public function update($id, $data)
    {
        $position = Position::findOrFail($id);
        $position->update($data);
        return $position;
    }

    public function delete($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
    }
}
