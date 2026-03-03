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
            'workhome_requests',
            'overtime_requests',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('related', 50)->after('user_id');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'mission_requests',
            'money_requests',
            'workhome_requests',
            'overtime_requests',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('related');
            });
        }
    }
};
