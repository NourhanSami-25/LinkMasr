<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $fillable = [
        'name',
        'code',
        'rate'
    ];
}
