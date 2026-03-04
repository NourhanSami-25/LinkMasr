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
        Schema::table('cost_estimate_items', function (Blueprint $table) {
            // Make the total column nullable since we're using subtotal
            $table->decimal('total', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_estimate_items', function (Blueprint $table) {
            $table->decimal('total', 12, 2)->nullable(false)->change();
        });
    }
};