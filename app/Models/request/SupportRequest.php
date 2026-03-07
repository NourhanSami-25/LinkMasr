<?php

namespace App\Models\request;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportRequest extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'follower',
        'handover',
        'status',
        'approver',
        'approver_id',
        'approver_name',
        'support_type',
        'purpose',
        'start_date',
        'end_date',
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
