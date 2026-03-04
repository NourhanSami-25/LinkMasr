<?php

namespace App\Models\finance;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;

use App\Models\common\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'project_id',
        'boq_id', // Construction BOQ link for EVM
        'task_id',
        'client_id',
        'client_name',
        'billing_address',
        'number',
        'is_repeated',
        'repeat_every',
        'repeat_counter',
        'type',
        'category', // 'operational', 'capital'
        'payment_method',
        'date',
        'currency',
        'sale_agent',
        'discount_type',
        'discount_amount_type',
        'status',
        'description',
        'client_note',
        'admin_note',
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
        'have_package',
        'package_date',
        'package_number',
        'total_balance',
        'created_by',
        'user_id', // Add for backward compatibility
        'subject', // Add for backward compatibility
        'reference', // Add for backward compatibility
        'amount' // Add for backward compatibility
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

    public function files()
    {
        return $this->morphMany(File::class, 'referable');
    }

    /**
     * Relation to Construction BOQ Item for EVM tracking
     */
    public function boqItem(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ConstructionBoq::class, 'boq_id');
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
     * Check if expense is fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->total;
    }

    /**
     * Check if expense is partially paid
     */
    public function isPartiallyPaid(): bool
    {
        return $this->paid_amount > 0 && $this->paid_amount < $this->total;
    }

    /**
     * Update expense status based on payments
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
