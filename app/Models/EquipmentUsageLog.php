<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'date',
        'hours',
        'fuel_consumption',
        'work_description',
        'notes',
        'logged_by',
    ];

    protected $casts = [
        'date' => 'date',
        'hours' => 'decimal:2',
        'fuel_consumption' => 'decimal:2',
    ];

    public function assignment()
    {
        return $this->belongsTo(EquipmentAssignment::class, 'assignment_id');
    }

    public function logger()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'logged_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // Update total hours in assignment
            $totalHours = EquipmentUsageLog::where('assignment_id', $model->assignment_id)->sum('hours');
            $model->assignment->update(['hours_used' => $totalHours]);
        });
    }
}
