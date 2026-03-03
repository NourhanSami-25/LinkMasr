<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    protected $fillable = [
        'contract_id',
        'installment_number',
        'amount',
        'due_date',
        'paid_date',
        'paid_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2'
    ];

    public function contract()
    {
        return $this->belongsTo(SalesContract::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\finance\Pyment::class, 'schedule_id');
    }

    /**
     * Check if overdue
     */
    public function getIsOverdueAttribute()
    {
        if ($this->status == 'paid') return false;
        return $this->due_date->isPast();
    }

    /**
     * Get remaining amount
     */
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
}
