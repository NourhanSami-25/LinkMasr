<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'boq_id',
        'description',
        'unit',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    /**
     * Get the tender this item belongs to.
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * Get the BOQ item.
     */
    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    /**
     * Get the bid items for this tender item.
     */
    public function bidItems()
    {
        return $this->hasMany(TenderBidItem::class);
    }
}
