<?php

namespace App\Services\utility;


use App\Models\utility\Todo;
use Illuminate\Support\Facades\Auth;


class TodoService
{
    public function getAll()
    {
        return Todo::where('user_id', Auth::id())->get();
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        return Todo::create($data);
    }

    public function getItemById($id)
    {
        $todo = Todo::findOrFail($id);
        return $todo;
    }

    public function update($id, $data)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($data);
        return $todo;
    }

    public function delete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
    }
}
