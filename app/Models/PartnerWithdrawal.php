<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerWithdrawal extends Model
{
    protected $fillable = [
        'partner_id',
        'project_id',
        'amount',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function partner()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'partner_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }
}
