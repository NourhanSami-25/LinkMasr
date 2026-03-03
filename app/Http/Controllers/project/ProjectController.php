<?php

namespace App\Http\Controllers\project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\client\Client;
use App\Models\user\User;
use App\Models\project\Project;
use App\Models\reminder\Reminder;
use App\Services\project\ProjectService;
use App\Http\Requests\project\ProjectRequest;
use App\Services\common\DiscussionService;
use App\Services\reminder\AutoReminderService;
use App\Services\utility\NotificationService;
use Exception;

class ProjectController extends Controller
{
    protected $projectService,
        $notificationService, $discussionService;

    public function __construct(ProjectService $projectService, NotificationService $notificationService, DiscussionService $discussionService)
    {
        $this->projectService = $projectService;
        $this->notificationService = $notificationService;
        $this->discussionService = $discussionService;
    }

    public function index()
    {
        $this->authorize('accessproject', ['view']);
        $projects = $this->projectService->getAll()->reverse();
        return view('project.index', compact('projects'));
    }


    public function create()
    {
        $this->authorize('accessproject', ['create']);
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('project.create', compact('clients', 'users'));
    }


    public function store(ProjectRequest $request)
    {
        try {
            $project = $this->projectService->create($request->validated());
            AutoReminderService::create('project', 'project', $project);
            $this->discussionService->createFor($project);
            if ($project->assignees)
                $this->notificationService->notify('Create Project: ' . $project->subject, '', 'none', __getUsersFromIds($project->assignees));
            return redirect()->route('projects.show', $project->id)->with('success', 'Project Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessproject', ['details']);
        $project = $this->projectService->getItemById($id);
        $item = $project;
        $files = $project->files()->get();
        $notes = $project->notes;
        $reminders = $project->reminders->reverse();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $tasks = $project->tasks->reverse();

        return view('project.show', compact('project', 'item', 'files', 'reminders', 'notes', 'users', 'tasks'));
    }



    public function edit($id)
    {
        $this->authorize('accessproject', ['modify']);
        $project = $this->projectService->getItemById($id);
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('project.edit', compact('project',  'clients', 'users'));
    }



    public function update(ProjectRequest $request, $id)
    {
        try {
            $project = $this->projectService->update($id, $request->validated());
            AutoReminderService::update($project);
            if ($project->assignees)
                $this->notificationService->notify('Update Project:' . $project->subject, '', 'none', __getUsersFromIds($project->assignees));
            return redirect()->route('projects.show', $project->id)->with('success', 'Project Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessproject', ['delete']);
            $project = Project::findOrFail($id);
            if ($project->assignees)
                $this->notificationService->notify('Delete Project:' . $project->subject, '', 'none', __getUsersFromIds($project->assignees));
            $this->projectService->delete($id);
            return redirect()->route('projects.index')->with('success', 'Project Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
