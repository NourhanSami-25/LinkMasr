<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesContract extends Model
{
    protected $fillable = [
        'contract_number',
        'project_id',
        'unit_id',
        'client_id',
        'total_price',
        'down_payment',
        'remaining_amount',
        'installment_months',
        'contract_date',
        'delivery_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'contract_date' => 'date',
        'delivery_date' => 'date',
        'total_price' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'remaining_amount' => 'decimal:2'
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function unit()
    {
        return $this->belongsTo(\App\Models\real_estate\PropertyUnit::class, 'unit_id');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\client\Client::class);
    }

    public function schedules()
    {
        return $this->hasMany(PaymentSchedule::class, 'contract_id');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\finance\Pyment::class, 'contract_id');
    }

    /**
     * Get total paid amount
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('total');
    }

    /**
     * Get remaining balance
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->total_price - $this->total_paid;
    }

    /**
     * Get payment progress percentage
     */
    public function getPaymentProgressAttribute()
    {
        if ($this->total_price == 0) return 0;
        return ($this->total_paid / $this->total_price) * 100;
    }
}
