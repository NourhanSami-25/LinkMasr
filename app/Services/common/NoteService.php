<?php

namespace App\Services\common;

use Illuminate\Support\Facades\Storage;
use App\Models\common\Note;
use Illuminate\Support\Facades\Auth;


class NoteService
{
    public function create(array $data)
    {
        $model = $data['model_type']::findOrFail($data['model_id']);
        
        // Get the current user's name for the username field
        $currentUser = auth()->user();
        $username = $currentUser ? $currentUser->name : 'Unknown User';
        
        $model->notes()->create([
            'content' => $data['content'],
            'username' => $username,
        ]);
    }

    public function update($id, array $data)
    {
        $note = Note::findOrFail($id);
        $note->update($data);
        return $note;
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
    }
}
