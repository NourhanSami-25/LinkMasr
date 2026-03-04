<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to add columns
        DB::statement('ALTER TABLE leads ADD COLUMN client_name VARCHAR(255)');
        DB::statement('ALTER TABLE leads ADD COLUMN address VARCHAR(255)');
        DB::statement('ALTER TABLE leads ADD COLUMN number INTEGER');
        DB::statement('ALTER TABLE leads ADD COLUMN subject VARCHAR(255)');
        DB::statement('ALTER TABLE leads ADD COLUMN sale_agent INTEGER');
        DB::statement('ALTER TABLE leads ADD COLUMN created_by INTEGER');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'address', 'number', 'subject', 'sale_agent', 'created_by']);
        });
    }
};