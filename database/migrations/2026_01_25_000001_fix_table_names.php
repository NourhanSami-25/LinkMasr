<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Align 'payment_requests' (Migration) with 'paymentrequests' (Model/ERP.sql)
        if (Schema::hasTable('payment_requests') && !Schema::hasTable('paymentrequests')) {
            Schema::rename('payment_requests', 'paymentrequests');
        }

        // Align 'credit_notes' (Migration) with 'creditnotes' (Model/ERP.sql)
        if (Schema::hasTable('credit_notes') && !Schema::hasTable('creditnotes')) {
            Schema::rename('credit_notes', 'creditnotes');
        }

        // Align 'payments' (Migration) with 'pyments' (Model/ERP.sql)
        // Note: Model is 'Pyment', defaults to 'pyments'. ERP.sql has 'pyments'.
        if (Schema::hasTable('payments') && !Schema::hasTable('pyments')) {
            Schema::rename('payments', 'pyments');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Revert names if needed, but risky if data added.
        if (Schema::hasTable('paymentrequests') && !Schema::hasTable('payment_requests')) {
            Schema::rename('paymentrequests', 'payment_requests');
        }
        if (Schema::hasTable('creditnotes') && !Schema::hasTable('credit_notes')) {
            Schema::rename('creditnotes', 'credit_notes');
        }
        if (Schema::hasTable('pyments') && !Schema::hasTable('payments')) {
            Schema::rename('pyments', 'payments');
        }
    }
};
