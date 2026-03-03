<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcontractorInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcontract_id',
        'invoice_no',
        'sequence_no',
        'period_from',
        'period_to',
        'gross_amount',
        'retention_amount',
        'advance_deduction',
        'previous_payments',
        'net_amount',
        'status',
        'submitted_by',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'period_from' => 'date',
        'period_to' => 'date',
        'approved_at' => 'date',
        'gross_amount' => 'decimal:2',
        'retention_amount' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'previous_payments' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    /**
     * Get the subcontract.
     */
    public function subcontract()
    {
        return $this->belongsTo(Subcontract::class);
    }

    /**
     * Get the invoice items.
     */
    public function items()
    {
        return $this->hasMany(SubcontractorInvoiceItem::class, 'invoice_id');
    }

    /**
     * Get the user who submitted this invoice.
     */
    public function submitter()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'submitted_by');
    }

    /**
     * Get the user who approved this invoice.
     */
    public function approver()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'approved_by');
    }

    /**
     * Calculate totals from items.
     */
    public function calculateTotals()
    {
        $grossAmount = $this->items->sum('amount');
        $retentionAmount = $grossAmount * ($this->subcontract->retention_percentage / 100);
        
        // Calculate advance deduction (proportional to this invoice)
        $advanceDeduction = 0;
        if ($this->subcontract->advance_paid > 0) {
            $totalContractValue = $this->subcontract->contract_value;
            $advanceDeduction = ($grossAmount / $totalContractValue) * $this->subcontract->advance_paid;
        }
        
        $netAmount = $grossAmount - $retentionAmount - $advanceDeduction - $this->previous_payments;
        
        $this->update([
            'gross_amount' => $grossAmount,
            'retention_amount' => $retentionAmount,
            'advance_deduction' => $advanceDeduction,
            'net_amount' => $netAmount,
        ]);
    }

    /**
     * Generate invoice number.
     */
    public static function generateInvoiceNo($subcontractId)
    {
        $subcontract = Subcontract::find($subcontractId);
        $count = self::where('subcontract_id', $subcontractId)->count() + 1;
        return sprintf('%s-INV-%03d', $subcontract->contract_no, $count);
    }

    /**
     * Get next sequence number.
     */
    public static function getNextSequence($subcontractId)
    {
        return self::where('subcontract_id', $subcontractId)->max('sequence_no') + 1;
    }
}
