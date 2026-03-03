<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    protected $fillable = [
        'name',
        'description',
        'related',
        'status'
    ];
}
