<?php

namespace App\Services\utility;


use App\Models\utility\Todo;
use App\Models\utility\TodoItem;
use Illuminate\Support\Facades\Auth;


class TodoItemService
{
    public function getAll($todoId)
    {
        return TodoItem::where('todo_id', $todoId)->get();
    }

    public function create(array $data)
    {
        return TodoItem::create($data);
    }

    public function getItemById($id)
    {
        return TodoItem::findOrFail($id);
    }

    public function update($id, $data)
    {
        $item = TodoItem::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function toggleStatus($id, $status)
    {
        $item = TodoItem::findOrFail($id);
        $item->status = $status;
        $item->save();
        return $item;
    }

    public function delete($id)
    {
        $item = TodoItem::findOrFail($id);
        return $item->delete();
    }
}
