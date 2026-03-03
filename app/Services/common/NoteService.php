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
        $model->notes()->create([
            'content' => $data['content'],
            'created_by' => auth::id(),
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
