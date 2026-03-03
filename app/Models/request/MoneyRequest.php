<?php

namespace App\Models\request;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneyRequest extends Model
{
    protected $fillable = [
        'user_id',
        'related',
        'related_work',
        'amount',
        'subject',
        'description',
        'date',
        'due_date',
        'duration',
        'duration_type',
        'follower',
        'handover',
        'status',
        'approver',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
