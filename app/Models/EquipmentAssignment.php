<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'project_id',
        'boq_id',
        'start_date',
        'end_date',
        'hours_used',
        'estimated_cost',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'hours_used' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    public function usageLogs()
    {
        return $this->hasMany(EquipmentUsageLog::class, 'assignment_id');
    }

    public function getActualCostAttribute()
    {
        return $this->hours_used * $this->equipment->hourly_rate;
    }
}
