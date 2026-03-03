<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueDistributionItem extends Model
{
    protected $fillable = [
        'distribution_id',
        'partner_id',
        'capital_share_percentage',
        'management_fee_percentage',
        'share_amount',
        'management_fee_amount',
        'total_amount'
    ];

    protected $casts = [
        'capital_share_percentage' => 'decimal:2',
        'management_fee_percentage' => 'decimal:2',
        'share_amount' => 'decimal:2',
        'management_fee_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function distribution()
    {
        return $this->belongsTo(RevenueDistribution::class);
    }

    public function partner()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'partner_id');
    }
}
