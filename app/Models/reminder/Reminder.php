<?php

namespace App\Models\reminder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'referable_id',
        'referable_type',
        'subject',
        'date',
        'remind_before',
        'remind_at_event',
        'before_reminded',
        'event_reminded',
        'priority',
        'status',
        'is_repeated',
        'repeat_every',
        'repeat_every_type',
        'members',
        'created_by',
    ];

    public function referable()
    {
        return $this->morphTo();
    }
}
