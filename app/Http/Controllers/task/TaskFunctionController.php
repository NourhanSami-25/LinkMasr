<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\task\Task;

class TaskFunctionController extends Controller
{
    public function change_status(Task $task, $status)
    {
        $this->authorize('accesstask', ['modify']);
        // Validate the status
        if (!in_array($status, ['in_progress', 'on_hold', 'not_started', 'completed'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        // Update the task status
        $task->update(['status' => $status]);
        return redirect()->back()->with('success', 'Task status updated successfully.');
    }
}
