<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'vendor_id',
        'request_id',
        'po_no',
        'date',
        'delivery_date',
        'subtotal',
        'vat_percentage',
        'vat_amount',
        'total_amount',
        'status',
        'terms',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'vat_percentage' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'request_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'po_id');
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class, 'po_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'created_by');
    }

    public function calculateTotals()
    {
        $subtotal = $this->items->sum('total_price');
        $vatAmount = $subtotal * ($this->vat_percentage / 100);
        
        $this->update([
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'total_amount' => $subtotal + $vatAmount,
        ]);
    }

    public static function generatePoNo($projectId)
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('PO-%s-%04d-%03d', $year, $projectId, $count);
    }
}
