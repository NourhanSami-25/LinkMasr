<?php

namespace App\Models\finance;

use App\Models\client\Client;
use App\Models\project\Project;
use App\Models\task\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pyment extends Model
{
    protected $fillable = [
        'project_id',
        'task_id',
        'client_id',
        'task_id',
        'invoice_id',
        'creditNote_id',
        'pymentRequest_id',
        'expense_id',
        'related',
        'client_name',
        'number',
        'subject',
        'total',
        'date',
        'currency',
        'payment_mode',
        'payment_method',
        'transaction_number',
        'note',
        'status',
        'created_by',
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

    public function paymentRequest(): BelongsTo
    {
        return $this->belongsTo(PaymentRequest::class);
    }

    public function creditNote(): BelongsTo
    {
        return $this->belongsTo(CreditNote::class);
    }

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }
}
