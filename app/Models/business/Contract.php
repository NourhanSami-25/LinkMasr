<?php

namespace App\Models\business;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;
use App\Models\common\File;

use App\Models\reminder\Reminder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $fillable = [
        'project_id',
        'task_id',
        'client_id',
        'unit_id', // Real Estate unit link
        'client_name',
        'number',
        'subject',
        'description',
        'type',
        'date',
        'due_date',
        'currency',
        'content',
        'signature',
        'visible_to_client',
        'sale_agent',
        'total',
        'status',
        'created_by'
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

    /**
     * Relation to Real Estate Unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Models\real_estate\PropertyUnit::class, 'unit_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'referable');
    }

    public function reminders()
    {
        return $this->morphMany(Reminder::class, 'referable');
    }
}
