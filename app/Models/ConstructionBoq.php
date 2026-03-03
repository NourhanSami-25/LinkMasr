<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionBoq extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class, 'project_id');
    }

    public function progress()
    {
        return $this->hasMany(ConstructionProgress::class, 'boq_id');
    }

    public function resources()
    {
        return $this->hasMany(ConstructionBoqResource::class, 'boq_id');
    }
    
    public function tasks()
    {
        return $this->hasMany(\App\Models\task\Task::class, 'boq_id');
    }
    
    public function expenses()
    {
        return $this->hasMany(\App\Models\finance\Expense::class, 'boq_id');
    }

    /**
     * Get the breakdown items for this BOQ.
     */
    public function breakdownItems()
    {
        return $this->hasMany(BoqBreakdownItem::class, 'boq_id');
    }

    /**
     * Get the total of all breakdown items.
     */
    public function getBreakdownTotalAttribute()
    {
        return $this->breakdownItems->sum('total_price');
    }

    /**
     * Check if BOQ has breakdown analysis.
     */
    public function getHasBreakdownAttribute()
    {
        return $this->breakdownItems()->count() > 0;
    }
}
