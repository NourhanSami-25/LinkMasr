<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'version',
        'baseline_start',
        'baseline_end',
        'is_active',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'baseline_start' => 'date',
        'baseline_end' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    /**
     * Get the creator.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'created_by');
    }

    /**
     * Get the tasks.
     */
    public function tasks()
    {
        return $this->hasMany(ScheduleTask::class, 'schedule_id');
    }

    /**
     * Get root tasks (no parent).
     */
    public function rootTasks()
    {
        return $this->tasks()->whereNull('parent_id')->orderBy('sort_order');
    }

    /**
     * Get total duration in days.
     */
    public function getTotalDaysAttribute()
    {
        return $this->baseline_start->diffInDays($this->baseline_end);
    }

    /**
     * Get overall progress.
     */
    public function getOverallProgressAttribute()
    {
        $tasks = $this->tasks()->whereNull('parent_id')->get();
        if ($tasks->isEmpty()) return 0;
        
        $totalWeight = $tasks->sum('weight');
        if ($totalWeight == 0) return 0;
        
        $weightedProgress = $tasks->sum(function ($task) {
            return $task->actual_progress * $task->weight;
        });
        
        return round($weightedProgress / $totalWeight, 2);
    }
}
