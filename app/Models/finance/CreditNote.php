<?php

namespace App\Models\finance;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CreditNote extends Model
{
    protected $table = 'creditnotes';

    protected $fillable = [
        'project_id',
        'task_id',
        'client_id',
        'invoice_id',
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
        'created_by',
        'user_id',
        'payment_currency'
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

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function financeItems()
    {
        return $this->morphMany(FinanceItem::class, 'referable');
    }

    public function pyments(): HasMany
    {
        return $this->hasMany(Pyment::class);
    }
}
