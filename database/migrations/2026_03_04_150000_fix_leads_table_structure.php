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
        Schema::table('leads', function (Blueprint $table) {
            // Add missing columns
            $table->string('client_name', 255)->after('id');
            $table->string('address', 255)->nullable()->after('client_name');
            $table->integer('number')->unique()->after('address');
            $table->string('subject', 255)->after('number');
            $table->unsignedBigInteger('sale_agent')->nullable()->after('source');
            $table->unsignedBigInteger('created_by')->nullable()->after('status');
            
            // Make client_id nullable since we're using client_name instead
            $table->unsignedBigInteger('client_id')->nullable()->change();
            
            // Make user_id nullable since we're using sale_agent instead
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Rename name to keep both for compatibility
            $table->renameColumn('name', 'lead_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'address', 'number', 'subject', 'sale_agent', 'created_by']);
            $table->renameColumn('lead_name', 'name');
        });
    }
};