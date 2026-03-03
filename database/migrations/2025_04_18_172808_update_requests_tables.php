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
            'mission_requests',
            'money_requests',
            'support_requests',
            'permission_requests',
            'vacation_requests',
            'workhome_requests',
            'overtime_requests',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('approver', 255)->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'mission_requests',
            'money_requests',
            'support_requests',
            'permission_requests',
            'vacation_requests',
            'workhome_requests',
            'overtime_requests',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('approver');
            });
        }
    }
};
