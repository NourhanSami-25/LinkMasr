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
            if (!Schema::hasColumn('paymentrequests', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->after('task_id');
                $table->index('client_id');
            }
            
            if (!Schema::hasColumn('paymentrequests', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('client_id');
                $table->index('project_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paymentrequests', function (Blueprint $table) {
            if (Schema::hasColumn('paymentrequests', 'client_id')) {
                $table->dropColumn('client_id');
            }
            
            if (Schema::hasColumn('paymentrequests', 'project_id')) {
                $table->dropColumn('project_id');
            }
        });
    }
};