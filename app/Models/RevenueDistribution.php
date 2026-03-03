<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueDistribution extends Model
{
    protected $fillable = [
        'project_id',
        'distribution_date',
        'total_revenue',
        'total_capital_expenses',
        'total_revenue_expenses',
        'total_management_fees',
        'distributable_amount',
        'breakeven_reached',
        'notes'
    ];

    protected $casts = [
        'distribution_date' => 'date',
        'total_revenue' => 'decimal:2',
        'total_capital_expenses' => 'decimal:2',
        'total_revenue_expenses' => 'decimal:2',
        'total_management_fees' => 'decimal:2',
        'distributable_amount' => 'decimal:2',
        'breakeven_reached' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function items()
    {
        return $this->hasMany(RevenueDistributionItem::class, 'distribution_id');
    }
}
