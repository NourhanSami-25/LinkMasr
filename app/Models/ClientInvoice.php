<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'invoice_no',
        'sequence_no',
        'period_from',
        'period_to',
        'gross_amount',
        'retention_amount',
        'advance_deduction',
        'previous_certified',
        'net_amount',
        'vat_percentage',
        'vat_amount',
        'total_with_vat',
        'status',
        'created_by',
        'certified_by',
        'certified_at',
        'notes',
    ];

    protected $casts = [
        'period_from' => 'date',
        'period_to' => 'date',
        'certified_at' => 'date',
        'gross_amount' => 'decimal:2',
        'retention_amount' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'previous_certified' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'vat_percentage' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_with_vat' => 'decimal:2',
    ];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    /**
     * Get the client.
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\client\Client::class);
    }

    /**
     * Get the invoice items.
     */
    public function items()
    {
        return $this->hasMany(ClientInvoiceItem::class, 'invoice_id');
    }

    /**
     * Get the creator.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'created_by');
    }

    /**
     * Get the certifier.
     */
    public function certifier()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'certified_by');
    }

    /**
     * Calculate totals from items.
     */
    public function calculateTotals($retentionPercentage = 10, $vatPercentage = 15)
    {
        $grossAmount = $this->items->sum('amount');
        $retentionAmount = $grossAmount * ($retentionPercentage / 100);
        $netAmount = $grossAmount - $retentionAmount - $this->advance_deduction - $this->previous_certified;
        $vatAmount = $netAmount * ($vatPercentage / 100);
        $totalWithVat = $netAmount + $vatAmount;
        
        $this->update([
            'gross_amount' => $grossAmount,
            'retention_amount' => $retentionAmount,
            'net_amount' => $netAmount,
            'vat_percentage' => $vatPercentage,
            'vat_amount' => $vatAmount,
            'total_with_vat' => $totalWithVat,
        ]);
    }

    /**
     * Generate invoice number.
     */
    public static function generateInvoiceNo($projectId)
    {
        $year = date('Y');
        $count = self::where('project_id', $projectId)->whereYear('created_at', $year)->count() + 1;
        return sprintf('CI-%s-%04d-%03d', $year, $projectId, $count);
    }

    /**
     * Get next sequence number.
     */
    public static function getNextSequence($projectId)
    {
        return self::where('project_id', $projectId)->max('sequence_no') + 1;
    }
}
