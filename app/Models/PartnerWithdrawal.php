<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\user\User;

class PartnerWithdrawal extends Model
{
    protected $fillable = [
        'partner_id',
        'amount',
        'withdrawal_method',
        'reference_number',
        'withdrawal_date',
        'status',
        'notes',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'withdrawal_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scope for pending withdrawals
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for completed withdrawals
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}