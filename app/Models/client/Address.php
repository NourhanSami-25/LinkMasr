<?php

namespace App\Models\client;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'client_id',
        'country',
        'state',
        'city',
        'street_name',
        'street_number',
        'building_number',
        'floor_number',
        'unit_number',
        'zip_code',
        'status'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
