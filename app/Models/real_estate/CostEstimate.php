<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\project\Project;

class CostEstimate extends Model
{
    protected $table = 'cost_estimates';

    protected $fillable = [
        'project_id',
        'unit_id',
        'title',
        'type',
        'licensing_fees',
        'other_fees',
        'materials_total',
        'total_cost',
        'created_by',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CostEstimateItem::class, 'estimate_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(PropertyUnit::class);
    }
}
