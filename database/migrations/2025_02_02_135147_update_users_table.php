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
        Schema::table('users', function (Blueprint $table) {
            // Skip dropping foreign keys for SQLite compatibility
            if (config('database.default') !== 'sqlite') {
                $table->dropForeign(['position_id']);
                $table->dropForeign(['role_id']);
            }
            $table->dropColumn(['first_name', 'last_name', 'position_id', 'role_id']);

            $table->string('name', 255)->after('id');
            $table->string('job_title', 50)->nullable()->after('department_id');
            $table->string('position', 50)->nullable()->after('job_title');
            $table->string('phone', 50)->nullable()->after('position');
            $table->string('address', 255)->nullable()->after('phone');
            $table->string('linkedin', 255)->nullable()->after('address');
            $table->string('facebook', 255)->nullable()->after('linkedin');
            $table->string('signature', 255)->nullable()->after('facebook');
            $table->integer('hourly_rate')->nullable()->after('signature');
            $table->string('accountant_record', length: 255)->nullable()->after('hourly_rate');
            $table->string('photo', 255)->nullable()->after('accountant_record');
            $table->string('bio', '2048')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio', 'phone', 'address', 'linkedin', 'facebook', 'signature',
                'hourly_rate', 'accountant_record', 'photo', 'last_login',
                'job_title', 'position'
            ]);
        });
    }
};
