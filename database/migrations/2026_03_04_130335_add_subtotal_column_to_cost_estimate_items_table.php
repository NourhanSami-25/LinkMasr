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
            // Add subtotal column that the model expects
            $table->decimal('subtotal', 12, 2)->default(0)->after('unit_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_estimate_items', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};