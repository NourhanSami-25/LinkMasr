<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'code',
        'name',
        'category',
        'model',
        'serial_number',
        'plate_number',
        'purchase_date',
        'purchase_cost',
        'current_value',
        'depreciation_rate',
        'daily_rate',
        'hourly_rate',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_cost' => 'decimal:2',
        'current_value' => 'decimal:2',
        'depreciation_rate' => 'decimal:2',
        'daily_rate' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
    ];

    public function assignments()
    {
        return $this->hasMany(EquipmentAssignment::class);
    }

    public function maintenance()
    {
        return $this->hasMany(EquipmentMaintenance::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(EquipmentAssignment::class)
            ->whereNull('end_date')
            ->latest();
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function getTotalHoursUsedAttribute()
    {
        return $this->assignments->sum('hours_used');
    }
}
