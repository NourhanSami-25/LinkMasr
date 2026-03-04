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
        Schema::table('paymentrequests', function (Blueprint $table) {
            // Make payment_currency nullable
            $table->string('payment_currency')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paymentrequests', function (Blueprint $table) {
            // Revert back to not nullable (if needed)
            $table->string('payment_currency')->nullable(false)->change();
        });
    }
};