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
        Schema::table('creditnotes', function (Blueprint $table) {
            if (!Schema::hasColumn('creditnotes', 'payment_currency')) {
                $table->string('payment_currency')->default('EGP');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creditnotes', function (Blueprint $table) {
            $table->dropColumn('payment_currency');
        });
    }
};
