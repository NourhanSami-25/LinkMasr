<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientContact extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'email',
        'phone',
        'position',
        'is_primary',
        'status'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
