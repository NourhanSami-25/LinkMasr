<?php

namespace App\Models\business;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'client_id',
        'client_name',
        'number',
        'subject',
        'related',
        'description',
        'date',
        'due_date',
        'open_till',
        'currency',
        'discount_type',
        'payment_currency',
        'tags',
        'assigned',
        'sale_agent',
        'message',
        'total',
        'status',
        'created_by'
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'open_till' => 'date',
        'tags' => 'array',
        'assigned' => 'array',
        'total' => 'decimal:2',
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

}
