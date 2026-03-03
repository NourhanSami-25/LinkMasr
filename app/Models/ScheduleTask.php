<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ScheduleTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'boq_id',
        'parent_id',
        'wbs_code',
        'name',
        'planned_start',
        'planned_end',
        'actual_start',
        'actual_end',
        'planned_progress',
        'actual_progress',
        'weight',
        'duration_days',
        'sort_order',
        'color',
    ];

    protected $casts = [
        'planned_start' => 'date',
        'planned_end' => 'date',
        'actual_start' => 'date',
        'actual_end' => 'date',
        'planned_progress' => 'decimal:2',
        'actual_progress' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    /**
     * Get the schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(ProjectSchedule::class, 'schedule_id');
    }

    /**
     * Get the BOQ item.
     */
    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    /**
     * Get parent task.
     */
    public function parent()
    {
        return $this->belongsTo(ScheduleTask::class, 'parent_id');
    }

    /**
     * Get child tasks.
     */
    public function children()
    {
        return $this->hasMany(ScheduleTask::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get predecessors.
     */
    public function predecessors()
    {
        return $this->belongsToMany(
            ScheduleTask::class,
            'schedule_dependencies',
            'successor_id',
            'predecessor_id'
        )->withPivot('type', 'lag_days');
    }

    /**
     * Get successors.
     */
    public function successors()
    {
        return $this->belongsToMany(
            ScheduleTask::class,
            'schedule_dependencies',
            'predecessor_id',
            'successor_id'
        )->withPivot('type', 'lag_days');
    }

    /**
     * Calculate duration on save.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->planned_start && $model->planned_end) {
                $model->duration_days = Carbon::parse($model->planned_start)
                    ->diffInDays(Carbon::parse($model->planned_end)) + 1;
            }
        });
    }

    /**
     * Get status based on progress.
     */
    public function getStatusAttribute()
    {
        $today = Carbon::now();
        
        if ($this->actual_end) return 'completed';
        if ($this->actual_start && $today->gt($this->planned_end)) return 'delayed';
        if ($this->actual_start) return 'in_progress';
        if ($today->gt($this->planned_start)) return 'late_start';
        return 'not_started';
    }

    /**
     * Get variance in days.
     */
    public function getVarianceAttribute()
    {
        if (!$this->actual_start) return 0;
        
        $plannedDays = $this->planned_start->diffInDays($this->planned_end);
        
        if ($this->actual_end) {
            $actualDays = $this->actual_start->diffInDays($this->actual_end);
            return $actualDays - $plannedDays;
        }
        
        $today = Carbon::now();
        $actualDays = $this->actual_start->diffInDays($today);
        $expectedProgress = min(100, ($actualDays / $plannedDays) * 100);
        
        return $this->actual_progress - $expectedProgress;
    }

    /**
     * Format for Gantt chart.
     */
    public function toGanttFormat()
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'start' => $this->planned_start->format('Y-m-d'),
            'end' => $this->planned_end->format('Y-m-d'),
            'progress' => (int) $this->actual_progress,
            'dependencies' => $this->predecessors->pluck('id')->map(fn($id) => (string) $id)->implode(', '),
            'custom_class' => $this->color ? 'bar-' . $this->color : null,
        ];
    }
}
