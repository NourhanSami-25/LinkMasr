<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'name',
        'id_number',
        'job_title',
        'specialty',
        'daily_rate',
        'overtime_rate',
        'start_date',
        'end_date',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'daily_rate' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\user\User::class);
    }

    public function attendance()
    {
        return $this->hasMany(WorkerAttendance::class, 'worker_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
