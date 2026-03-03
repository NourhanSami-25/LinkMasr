<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingAddress extends Model
{
    protected $fillable = [
        'client_id',
        'bank_name',
        'address',
        'le_account',
        'le_iban',
        'le_swift_code',
        'us_account',
        'us_iban',
        'us_swift_code',
        'status'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
