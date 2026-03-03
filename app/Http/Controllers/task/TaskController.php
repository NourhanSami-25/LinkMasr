<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\client\Client;
use App\Models\task\Task;
use App\Models\user\User;
use App\Models\project\Project;
use App\Services\task\TaskService;
use App\Http\Requests\task\TaskRequest;
use App\Services\reminder\AutoReminderService;
use App\Services\common\DiscussionService;
use App\Services\utility\NotificationService;
use Exception;

class TaskController extends Controller
{
    protected $taskService,
        $autoReminderService, $notificationService, $discussionService;

    public function __construct(TaskService $taskService, NotificationService $notificationService, DiscussionService $discussionService)
    {
        $this->taskService = $taskService;
        $this->notificationService = $notificationService;
        $this->discussionService = $discussionService;
    }

    public function index()
    {
        $this->authorize('accesstask', ['view']);
        $tasks = $this->taskService->getAll()->reverse();
        return view('task.index', compact('tasks'));
    }


    public function create()
    {
        $this->authorize('accesstask', ['create']);
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('task.create', compact('projects', 'clients', 'users'));
    }


    public function store(TaskRequest $request)
    {
        try {
            $task = $this->taskService->create($request->validated());
            AutoReminderService::create('task', 'task', $task);
            $this->discussionService->createFor($task);
            if ($task->assignees)
                $this->notificationService->notify('Create Task: ' . $task->subject, '', 'none', __getUsersFromManyIds($task->assignees, $task->followers));
            return redirect()->route('tasks.show', $task->id)->with('success', 'Task Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesstask', ['details']);
        $task = $this->taskService->getItemById($id);
        $item = $task;
        $files = $task->files()->get();
        $notes = $task->notes;
        $discussion = $task->load('discussion');
        $reminders = $task->reminders->reverse();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('task.show', compact('task', 'files', 'reminders', 'notes', 'users', 'discussion', 'item'));
    }



    public function edit($id)
    {
        $this->authorize('accesstask', ['modify']);
        $task = $this->taskService->getItemById($id);
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('task.edit', compact('task', 'projects', 'clients', 'users'));
    }



    public function update(TaskRequest $request, $id)
    {
        try {
            $task = $this->taskService->update($id, $request->validated());
            AutoReminderService::update($task);
            if ($task->assignees)
                $this->notificationService->notify('Update Task: ' . $task->subject, '', 'none', __getUsersFromIds(json_encode($task->assignees)));
            return redirect()->route('tasks.show', $task->id)->with('success', 'Task Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accesstask', ['delete']);
            $task = Task::findOrFail($id);
            if ($task->assignees)
                $this->notificationService->notify('Delete Task: ' . $task->subject, '', 'none', __getUsersFromManyIds($task->assignees, $task->followers));
            $this->taskService->delete($id);
            return redirect()->route('tasks.index')->with('success', 'Task Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
