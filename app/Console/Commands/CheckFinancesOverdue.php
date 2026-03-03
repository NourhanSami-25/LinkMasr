<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\finance\Invoice;
use App\Models\finance\PaymentRequest;
use App\Models\finance\CreditNote;
use Carbon\Carbon;

class CheckFinancesOverdue extends Command
{
    protected $signature = 'finances:check-overdue';
    protected $description = 'Mark invoices, payment requests, and credit notes as overdue if past due_date';

    public function handle()
    {
        $today = Carbon::today();
        $excludedStatuses = ['paid', 'draft', 'accepted', 'declined'];
        $overdueItems = [];

        $invoices = Invoice::whereDate('due_date', '<', $today)
            ->whereNotIn('status', $excludedStatuses)
            ->get();

        foreach ($invoices as $invoice) {
            $invoice->status = 'overdue';
            $invoice->save();

            $overdueItems[] = [
                'type' => 'invoice',
                'id' => $invoice->id,
                'number' => $invoice->number,
            ];
        }

        $paymentRequests = PaymentRequest::whereDate('due_date', '<', $today)
            ->whereNotIn('status', $excludedStatuses)
            ->get();

        foreach ($paymentRequests as $paymentRequest) {
            $paymentRequest->status = 'expired';
            $paymentRequest->save();

            $overdueItems[] = [
                'type' => 'paymentRequest',
                'id' => $paymentRequest->id,
                'number' => $paymentRequest->number,
            ];
        }

        $creditNotes = CreditNote::whereDate('due_date', '<', $today)
            ->whereNotIn('status', $excludedStatuses)
            ->get();

        foreach ($creditNotes as $creditNote) {
            $creditNote->status = 'overdue';
            $creditNote->save();

            $overdueItems[] = [
                'type' => 'creditNote',
                'id' => $creditNote->id,
                'number' => $creditNote->number,
            ];
        }

        if (!empty($overdueItems)) {
            // HERE NOTIFY USERS WITH $overdueItems
        }

        $this->info('Overdue financial records updated and user notified.');
    }
}
