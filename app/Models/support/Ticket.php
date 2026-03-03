<?php

namespace App\Models\ticket;

use App\Models\project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'project_id',
        'number',
        'subject',
        'content',
        'priority',
        'type',
        'tags',
        'status'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
