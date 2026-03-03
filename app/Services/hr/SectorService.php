<?php

namespace App\Services\hr;


use App\Models\hr\Sector;

class SectorService
{
    public function getAll()
    {
        return Sector::all();
    }

    public function create(array $data)
    {
        return Sector::create($data);
    }

    public function update($id, $data)
    {
        $sector = Sector::findOrFail($id);
        $sector->update($data);
        return $sector;
    }

    public function delete($id)
    {
        $sector = Sector::findOrFail($id);
        $sector->delete();
    }
}
