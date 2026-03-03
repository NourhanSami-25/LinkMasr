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
                if (Schema::hasColumn('users', 'position_id')) {
                    $table->dropForeign(['position_id']);
                }
                if (Schema::hasColumn('users', 'role_id')) {
                    $table->dropForeign(['role_id']);
                }
            }
            
            // Drop columns only if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('users', 'first_name')) {
                $columnsToDrop[] = 'first_name';
            }
            if (Schema::hasColumn('users', 'last_name')) {
                $columnsToDrop[] = 'last_name';
            }
            if (Schema::hasColumn('users', 'position_id')) {
                $columnsToDrop[] = 'position_id';
            }
            if (Schema::hasColumn('users', 'role_id')) {
                $columnsToDrop[] = 'role_id';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Only add name if it doesn't exist
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name', 255)->after('id');
            }
            if (!Schema::hasColumn('users', 'job_title')) {
                $table->string('job_title', 50)->nullable()->after('department_id');
            }
            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position', 50)->nullable()->after('job_title');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 50)->nullable()->after('position');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address', 255)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin', 255)->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'facebook')) {
                $table->string('facebook', 255)->nullable()->after('linkedin');
            }
            if (!Schema::hasColumn('users', 'signature')) {
                $table->string('signature', 255)->nullable()->after('facebook');
            }
            if (!Schema::hasColumn('users', 'hourly_rate')) {
                $table->integer('hourly_rate')->nullable()->after('signature');
            }
            if (!Schema::hasColumn('users', 'accountant_record')) {
                $table->string('accountant_record', length: 255)->nullable()->after('hourly_rate');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo', 255)->nullable()->after('accountant_record');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->string('bio', '2048')->nullable()->after('photo');
            }
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
