<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDependency extends Model
{
    use HasFactory;

    protected $fillable = [
        'predecessor_id',
        'successor_id',
        'type',
        'lag_days',
    ];

    /**
     * Get the predecessor task.
     */
    public function predecessor()
    {
        return $this->belongsTo(ScheduleTask::class, 'predecessor_id');
    }

    /**
     * Get the successor task.
     */
    public function successor()
    {
        return $this->belongsTo(ScheduleTask::class, 'successor_id');
    }

    /**
     * Get type description.
     */
    public function getTypeDescriptionAttribute()
    {
        return match($this->type) {
            'FS' => 'Finish to Start',
            'FF' => 'Finish to Finish',
            'SS' => 'Start to Start',
            'SF' => 'Start to Finish',
            default => $this->type,
        };
    }
}
