<?php

namespace App\Models\finance;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PaymentRequest extends Model
{
    protected $table = 'paymentrequests';

    protected $fillable = [
        'project_id',
        'task_id',
        'client_id',
        'client_name',
        'billing_address',
        'number',
        'reference',
        'is_repeated',
        'repeat_every',
        'repeat_counter',
        'date',
        'due_date',
        'currency',
        'payment_currency',
        'sale_agent',
        'discount_type',
        'discount_amount_type',
        'status',
        'send_status',
        'description',
        'admin_note',
        'client_note',
        'tax',
        'items_tax_value',
        'overall_tax_value',
        'adjustment',
        'discount',
        'percentage_discount_value',
        'fixed_discount',
        'subtotal',
        'total_tax',
        'total_discount',
        'total',
        'created_by',
        'user_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }


    public function financeItems()
    {
        return $this->morphMany(FinanceItem::class, 'referable');
    }

    public function pyments(): HasMany
    {
        return $this->hasMany(Pyment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the total paid amount from all related payments
     */
    public function getPaidAmountAttribute(): float
    {
        return $this->pyments()->where('status', 'paid')->sum('total') ?? 0;
    }

    /**
     * Get the remaining balance to be paid
     */
    public function getRemainingBalanceAttribute(): float
    {
        return max(0, $this->total - $this->paid_amount);
    }

    /**
     * Check if payment request is fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->total;
    }

    /**
     * Check if payment request is partially paid
     */
    public function isPartiallyPaid(): bool
    {
        return $this->paid_amount > 0 && $this->paid_amount < $this->total;
    }

    /**
     * Update payment request status based on payments
     */
    public function updateStatusBasedOnPayments(): void
    {
        if ($this->isFullyPaid()) {
            $this->status = 'paid';
        } elseif ($this->isPartiallyPaid()) {
            $this->status = 'partially_paid';
        } elseif ($this->paid_amount == 0 && $this->status !== 'draft') {
            $this->status = 'unpaid';
        }
        $this->save();
    }
}
