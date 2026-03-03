<?php
namespace App\Models\utility;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'type', 'staff_members', 
        'achievement', 'start_date', 'end_date', 
        'description', 'notify_when_achieved', 
        'notify_when_failed', 'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
