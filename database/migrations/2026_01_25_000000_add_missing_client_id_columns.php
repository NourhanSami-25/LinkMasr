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
        $tables = [
            'invoices' => ['client_id', 'project_id'],
            'payment_requests' => ['client_id', 'project_id'],
            'expenses' => ['client_id', 'project_id'],
            'payments' => ['client_id', 'project_id'],
            'credit_notes' => ['client_id', 'project_id'], // Covers migration name
            'creditnotes' => ['client_id', 'project_id'],   // Covers Model/SQL name
        ];

        foreach ($tables as $tableName => $columns) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
                    foreach ($columns as $column) {
                        if (!Schema::hasColumn($tableName, $column)) {
                            $table->unsignedBigInteger($column)->nullable()->index();
                            // Optional: Add foreign key if clients/projects exist
                            // $table->foreign($column)->references('id')->on(...);
                            // Avoiding constraints for now to prevent failures if parent IDs are missing
                        }
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down needed as this fixes a missing state
    }
};
