<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderBid extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'vendor_id',
        'bid_amount',
        'bid_date',
        'validity_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
        'bid_date' => 'date',
        'validity_date' => 'date',
    ];

    /**
     * Get the tender this bid belongs to.
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * Get the vendor who submitted this bid.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the bid items.
     */
    public function items()
    {
        return $this->hasMany(TenderBidItem::class, 'bid_id');
    }

    /**
     * Check if bid is valid.
     */
    public function getIsValidAttribute()
    {
        return $this->validity_date === null || now()->lte($this->validity_date);
    }
}
