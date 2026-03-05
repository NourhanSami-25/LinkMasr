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
        Schema::table('money_requests', function (Blueprint $table) {
            $table->timestamp('start_date')->nullable()->after('description');
        });
        
        // Rename due_date to end_date in a separate schema call
        Schema::table('money_requests', function (Blueprint $table) {
            $table->renameColumn('due_date', 'end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('money_requests', function (Blueprint $table) {
            $table->renameColumn('end_date', 'due_date');
        });
        
        Schema::table('money_requests', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }
};
