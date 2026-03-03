<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_id',
        'project_id',
        'grn_no',
        'date',
        'delivery_note',
        'notes',
        'received_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class, 'grn_id');
    }

    public function receiver()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'received_by');
    }

    public static function generateGrnNo($projectId)
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('GRN-%s-%04d-%03d', $year, $projectId, $count);
    }
}
