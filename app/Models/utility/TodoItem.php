<?php

namespace App\Models\utility;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoItem extends Model
{
    protected $fillable = [
        'todo_id',
        'subject',
        'date',
        'status',
    ];

    public function todo(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }
}
