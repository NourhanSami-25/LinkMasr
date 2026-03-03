<?php
namespace App\Models\finance;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = [
        'name', 'description'
    ];
}
