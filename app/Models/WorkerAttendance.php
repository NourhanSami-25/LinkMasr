<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerAttendance extends Model
{
    use HasFactory;

    protected $table = 'worker_attendance';

    protected $fillable = [
        'worker_id',
        'boq_id',
        'date',
        'check_in',
        'check_out',
        'hours_worked',
        'overtime_hours',
        'status',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'date' => 'date',
        'hours_worked' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
    ];

    public function worker()
    {
        return $this->belongsTo(ProjectWorker::class, 'worker_id');
    }

    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    public function recorder()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'recorded_by');
    }
}
