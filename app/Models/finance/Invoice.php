<?php

namespace App\Models\finance;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'pymentRequest_id',
        'project_id',
        'task_id',
        'client_id',
        'client_name',
        'billing_address',
        'number',
        'is_repeated',
        'repeat_every',
        'repeat_counter',
        'date',
        'due_date',
        'currency',
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
        'created_by'
    ];


    public function paymentRequest(): BelongsTo
    {
        return $this->belongsTo(PaymentRequest::class);
    }

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

    public function creditNotes(): HasMany
    {
        return $this->hasMany(CreditNote::class);
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
     * Check if invoice is fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->total;
    }

    /**
     * Check if invoice is partially paid
     */
    public function isPartiallyPaid(): bool
    {
        return $this->paid_amount > 0 && $this->paid_amount < $this->total;
    }

    /**
     * Update invoice status based on payments
     */
    public function updateStatusBasedOnPayments(): void
    {
        if ($this->isFullyPaid()) {
            $this->status = 'paid';
        } elseif ($this->isPartiallyPaid()) {
            $this->status = 'partially';
        } elseif ($this->paid_amount == 0 && $this->status !== 'draft') {
            $this->status = 'unpaid';
        }
        $this->save();
    }
}
