<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'decimal_separator',
        'thousand_separator',
        'currency_placement'
    ];
}
