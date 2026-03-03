<?php
namespace App\Models\utility;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'description', 
        'start_date', 'end_date', 'notify_time', 
        'time_unit', 'event_color', 'link', 
        'related_to', 'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
