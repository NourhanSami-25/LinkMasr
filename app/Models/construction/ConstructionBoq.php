<?php

namespace App\Models\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\project\Project;

class ConstructionBoq extends Model
{
    protected $fillable = [
        'project_id',
        'code',
        'item_description',
        'unit',
        'quantity',
        'unit_price',
        'total_price',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Calculate total price automatically
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($boq) {
            $boq->total_price = $boq->quantity * $boq->unit_price;
        });
    }

    // Get progress percentage (calculated based on dates)
    public function getProgressPercentageAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }

        $now = now();
        $start = $this->start_date;
        $end = $this->end_date;

        if ($now < $start) {
            return 0;
        }

        if ($now > $end) {
            return 100;
        }

        $totalDays = $start->diffInDays($end);
        $elapsedDays = $start->diffInDays($now);

        return $totalDays > 0 ? round(($elapsedDays / $totalDays) * 100, 2) : 0;
    }

    // Get actual cost (for now, we'll estimate based on progress)
    public function getActualCostAttribute()
    {
        return ($this->total_price * $this->progress_percentage) / 100;
    }
}