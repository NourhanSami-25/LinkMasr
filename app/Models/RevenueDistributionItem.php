<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\project\Project;
use App\Models\user\User;

class RevenueDistributionItem extends Model
{
    protected $fillable = [
        'project_id',
        'partner_id',
        'revenue_amount',
        'partner_percentage',
        'total_amount',
        'distribution_type',
        'distribution_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'revenue_amount' => 'decimal:2',
        'partner_percentage' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'distribution_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    // Calculate total amount automatically
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->total_amount = ($item->revenue_amount * $item->partner_percentage) / 100;
        });
    }

    // Scope for distributed items
    public function scopeDistributed($query)
    {
        return $query->where('status', 'distributed');
    }
}