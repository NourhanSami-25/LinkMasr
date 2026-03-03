<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'mission_requests',
            'money_requests',
            'permission_requests',
            'vacation_requests',
            'workhome_requests',
            'overtime_requests',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->integer('duration')->default(0)->after('due_date');
                $table->string('duration_type', 50)->default('days')->after('duration');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'mission_requests',
            'money_requests',
            'permission_requests',
            'vacation_requests',
            'workhome_requests',
            'overtime_requests',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('duration');
                $table->dropColumn('duration_type');
            });
        }
    }
};
