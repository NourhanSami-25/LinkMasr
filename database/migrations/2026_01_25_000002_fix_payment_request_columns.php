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
        // Align 'expire_date' (Migration) with 'due_date' (Model/ERP.sql)
        if (Schema::hasTable('paymentrequests')) {
            Schema::table('paymentrequests', function (Blueprint $table) {
                if (Schema::hasColumn('paymentrequests', 'expire_date') && !Schema::hasColumn('paymentrequests', 'due_date')) {
                    $table->renameColumn('expire_date', 'due_date');
                }
                // Fallback: if due_date is missing entirely
                elseif (!Schema::hasColumn('paymentrequests', 'due_date')) {
                    $table->dateTime('due_date')->nullable()->after('date');
                }
            });
            
            // Fix nullable if needed (erp.sql says DEFAULT NULL)
            Schema::table('paymentrequests', function (Blueprint $table) {
                if (Schema::hasColumn('paymentrequests', 'due_date')) {
                    $table->dateTime('due_date')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('paymentrequests')) {
             Schema::table('paymentrequests', function (Blueprint $table) {
                if (Schema::hasColumn('paymentrequests', 'due_date')) {
                    $table->renameColumn('due_date', 'expire_date');
                }
             });
        }
    }
};
