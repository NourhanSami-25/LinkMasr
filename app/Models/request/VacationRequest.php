<?php

namespace App\Models\request;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationRequest extends Model
{
    protected $fillable = [
        'user_id',
        'vacation_type',
        'subject',
        'description',
        'start_date',
        'end_date',
        'duration',
        'duration_type',
        'follower',
        'handover',
        'status',
        'approver_id',
        'approver_name',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
