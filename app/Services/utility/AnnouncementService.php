<?php

namespace App\Services\utility;


use App\Models\utility\Announcement;
use Illuminate\Support\Facades\Auth;


class AnnouncementService
{
    public function getAll()
    {
        return Announcement::all();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id();
        return Announcement::create($data);
    }

    public function getItemById($id)
    {
        $announcement = Announcement::findOrFail($id);
        return $announcement;
    }

    public function update($id, $data)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update($data);
        return $announcement;
    }

    public function delete($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
    }
}
