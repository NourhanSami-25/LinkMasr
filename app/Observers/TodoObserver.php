<?php

namespace App\Observers;

use App\Models\utility\Todo;
use App\Models\utility\TodoItem;
use Illuminate\Support\Facades\Log;

class TodoObserver
{
    public function deleting(Todo $todo)
    {
        try {
            todoItem::where('todo_id ', $todo->id)
                ->delete();
        } catch (\Exception $e) {
            Log::error('Error cleaning up related records for deleted todo: ' . $e->getMessage());
        }
    }
}
