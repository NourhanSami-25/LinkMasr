<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_id',
        'pr_item_id',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'total_price',
        'received_qty',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'received_qty' => 'decimal:4',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function prItem()
    {
        return $this->belongsTo(PurchaseRequestItem::class, 'pr_item_id');
    }

    public function receiptItems()
    {
        return $this->hasMany(GoodsReceiptItem::class, 'po_item_id');
    }

    public function getRemainingQtyAttribute()
    {
        return $this->quantity - $this->received_qty;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = $model->quantity * $model->unit_price;
        });
    }
}
