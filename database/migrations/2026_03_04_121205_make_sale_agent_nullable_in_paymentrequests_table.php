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
            // Make sale_agent nullable
            $table->string('sale_agent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paymentrequests', function (Blueprint $table) {
            // Revert back to not nullable (if needed)
            $table->string('sale_agent')->nullable(false)->change();
        });
    }
};