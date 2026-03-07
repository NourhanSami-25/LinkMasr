<?php

namespace App\Http\Controllers;

use App\Models\ProjectSchedule;
use App\Models\ScheduleTask;
use App\Models\ScheduleDependency;
use App\Models\ConstructionBoq;
use App\Models\project\Project;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index(Request $request)
    {
        $this->authorize('accessconstruction', ['view']);
        
        $query = ProjectSchedule::with('project', 'creator', 'tasks');
        
        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }
        
        $schedules = $query->orderBy('created_at', 'desc')->paginate(20);
        $projects = Project::all();
        
        return view('construction.schedule.index', compact('schedules', 'projects'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create(Request $request)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $projects = Project::all();
        $project = null;
        $boqItems = collect();
        
        if ($request->project_id) {
            $project = Project::with('boqItems')->findOrFail($request->project_id);
            $boqItems = $project->boqItems;
        }
        
        return view('construction.schedule.create', compact('projects', 'project', 'boqItems'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'baseline_start' => 'required|date',
            'baseline_end' => 'required|date|after_or_equal:baseline_start',
            'notes' => 'nullable|string',
            'import_from_boq' => 'nullable|boolean',
        ]);

        $schedule = ProjectSchedule::create([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'baseline_start' => $validated['baseline_start'],
            'baseline_end' => $validated['baseline_end'],
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        // Import tasks from BOQ if requested
        if ($request->import_from_boq) {
            $boqItems = ConstructionBoq::where('project_id', $validated['project_id'])->get();
            $sortOrder = 0;
            
            foreach ($boqItems as $boq) {
                ScheduleTask::create([
                    'schedule_id' => $schedule->id,
                    'boq_id' => $boq->id,
                    'name' => $boq->item_description,
                    'planned_start' => $boq->start_date ?? $validated['baseline_start'],
                    'planned_end' => $boq->end_date ?? $validated['baseline_end'],
                    'weight' => $boq->total_price,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('schedules.show', $schedule->id)
            ->with('success', 'تم إنشاء مخطط التنفيذ بنجاح');
    }

    /**
     * Display the specified schedule (Gantt Chart).
     */
    public function show($id)
    {
        $this->authorize('accessconstruction', ['view']);
        
        $schedule = ProjectSchedule::with([
            'project',
            'tasks' => function($q) {
                $q->orderBy('sort_order');
            },
            'tasks.predecessors',
            'tasks.boq',
        ])->findOrFail($id);
        
        // Format tasks for Gantt chart
        $ganttTasks = $schedule->tasks->map(function ($task) {
            return $task->toGanttFormat();
        });
        
        return view('construction.schedule.show', compact('schedule', 'ganttTasks'));
    }

    /**
     * Add a task to the schedule.
     */
    public function addTask(Request $request, $scheduleId)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'planned_start' => 'required|date',
            'planned_end' => 'required|date|after_or_equal:planned_start',
            'parent_id' => 'nullable|exists:schedule_tasks,id',
            'boq_id' => 'nullable|exists:construction_boqs,id',
            'weight' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:20',
        ]);

        $schedule = ProjectSchedule::findOrFail($scheduleId);
        $maxOrder = $schedule->tasks()->max('sort_order') ?? 0;
        
        $task = ScheduleTask::create([
            'schedule_id' => $scheduleId,
            'name' => $validated['name'],
            'planned_start' => $validated['planned_start'],
            'planned_end' => $validated['planned_end'],
            'parent_id' => $validated['parent_id'] ?? null,
            'boq_id' => $validated['boq_id'] ?? null,
            'weight' => $validated['weight'] ?? 0,
            'color' => $validated['color'] ?? null,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'تم إضافة المهمة بنجاح');
    }

    /**
     * Update a task.
     */
    public function updateTask(Request $request, $taskId)
    {
        $this->authorize('accessconstruction', ['modify']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'planned_start' => 'required|date',
            'planned_end' => 'required|date|after_or_equal:planned_start',
            'actual_start' => 'nullable|date',
            'actual_end' => 'nullable|date',
            'actual_progress' => 'nullable|numeric|min:0|max:100',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $task = ScheduleTask::findOrFail($taskId);
        $task->update($validated);

        return redirect()->back()->with('success', 'تم تحديث المهمة بنجاح');
    }

    /**
     * Delete a task.
     */
    public function deleteTask($taskId)
    {
        $this->authorize('accessconstruction', ['delete']);
        
        $task = ScheduleTask::findOrFail($taskId);
        $task->children()->delete();
        $task->delete();

        return redirect()->back()->with('success', 'تم حذف المهمة بنجاح');
    }

    /**
     * Add dependency between tasks.
     */
    public function addDependency(Request $request)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'predecessor_id' => 'required|exists:schedule_tasks,id',
            'successor_id' => 'required|exists:schedule_tasks,id|different:predecessor_id',
            'type' => 'required|in:FS,FF,SS,SF',
            'lag_days' => 'nullable|integer',
        ]);

        ScheduleDependency::updateOrCreate(
            [
                'predecessor_id' => $validated['predecessor_id'],
                'successor_id' => $validated['successor_id'],
            ],
            [
                'type' => $validated['type'],
                'lag_days' => $validated['lag_days'] ?? 0,
            ]
        );

        return redirect()->back()->with('success', 'تم إضافة التبعية بنجاح');
    }

    /**
     * Remove dependency.
     */
    public function removeDependency($predecessorId, $successorId)
    {
        $this->authorize('accessconstruction', ['delete']);
        
        ScheduleDependency::where('predecessor_id', $predecessorId)
            ->where('successor_id', $successorId)
            ->delete();

        return redirect()->back()->with('success', 'تم إزالة التبعية بنجاح');
    }

    /**
     * Get tasks as JSON for Gantt chart.
     */
    public function getTasksJson($scheduleId)
    {
        $schedule = ProjectSchedule::with(['tasks.predecessors'])->findOrFail($scheduleId);
        
        $tasks = $schedule->tasks->map(function ($task) {
            return $task->toGanttFormat();
        });
        
        return response()->json($tasks);
    }

    /**
     * Update task progress via AJAX.
     */
    public function updateProgress(Request $request, $taskId)
    {
        $validated = $request->validate([
            'progress' => 'required|numeric|min:0|max:100',
        ]);

        $task = ScheduleTask::findOrFail($taskId);
        $task->update(['actual_progress' => $validated['progress']]);

        return response()->json(['success' => true]);
    }
}
