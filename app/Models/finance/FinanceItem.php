<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FinanceItem extends Model
{
    protected $fillable = [
        'referable_id',
        'referable_type',
        'name',
        'description',
        'qty',
        'amount',
        'tax',
        'subtotal'
    ];

    public function referable(): MorphTo
    {
        return $this->morphTo();
    }
}
