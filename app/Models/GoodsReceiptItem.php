<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'grn_id',
        'po_item_id',
        'received_qty',
        'accepted_qty',
        'rejected_qty',
        'rejection_reason',
    ];

    protected $casts = [
        'received_qty' => 'decimal:4',
        'accepted_qty' => 'decimal:4',
        'rejected_qty' => 'decimal:4',
    ];

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class, 'grn_id');
    }

    public function poItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'po_item_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // Update received qty in PO item
            $totalReceived = GoodsReceiptItem::where('po_item_id', $model->po_item_id)->sum('accepted_qty');
            $model->poItem->update(['received_qty' => $totalReceived]);
            
            // Check if PO is fully received
            $poItem = $model->poItem;
            $po = $poItem->purchaseOrder;
            $allReceived = $po->items->every(function ($item) {
                return $item->received_qty >= $item->quantity;
            });
            
            if ($allReceived) {
                $po->update(['status' => 'received']);
            } elseif ($po->items->some(fn($item) => $item->received_qty > 0)) {
                $po->update(['status' => 'partial']);
            }
        });
    }
}
