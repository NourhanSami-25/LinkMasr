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
        Schema::table('cost_estimates', function (Blueprint $table) {
            // Add missing columns that the service expects
            $table->decimal('materials_total', 12, 2)->default(0)->after('other_fees');
            $table->decimal('total_cost', 12, 2)->default(0)->after('materials_total');
            $table->unsignedBigInteger('created_by')->nullable()->after('total_cost');
            
            // Add foreign key for created_by
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_estimates', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['materials_total', 'total_cost', 'created_by']);
        });
    }
};