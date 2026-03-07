<?php

namespace App\Models\request;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OvertimeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'related',
        'related_work',
        'subject',
        'description',
        'start_date',
        'end_date',
        'duration',
        'duration_type',
        'follower',
        'handover',
        'status',
        'approver',
        'approver_id',
        'approver_name',
        'task_name',
    ];

    protected $casts = [
        'follower' => 'array',
        'handover' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
