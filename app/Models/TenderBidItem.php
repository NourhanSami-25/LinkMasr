<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderBidItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bid_id',
        'tender_item_id',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the bid this item belongs to.
     */
    public function bid()
    {
        return $this->belongsTo(TenderBid::class, 'bid_id');
    }

    /**
     * Get the tender item.
     */
    public function tenderItem()
    {
        return $this->belongsTo(TenderItem::class);
    }

    /**
     * Auto-calculate total on save.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->tenderItem) {
                $model->total_price = $model->unit_price * $model->tenderItem->quantity;
            }
        });
    }
}
