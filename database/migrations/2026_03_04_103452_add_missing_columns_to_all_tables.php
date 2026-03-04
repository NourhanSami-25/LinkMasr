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
        // Add missing columns to proposals table
        if (Schema::hasTable('proposals')) {
            Schema::table('proposals', function (Blueprint $table) {
                if (!Schema::hasColumn('proposals', 'client_id')) {
                    $table->unsignedBigInteger('client_id')->nullable()->after('id');
                    $table->index('client_id');
                }
                if (!Schema::hasColumn('proposals', 'project_id')) {
                    $table->unsignedBigInteger('project_id')->nullable()->after('client_id');
                    $table->index('project_id');
                }
                if (!Schema::hasColumn('proposals', 'task_id')) {
                    $table->unsignedBigInteger('task_id')->nullable()->after('project_id');
                    $table->index('task_id');
                }
            });
        }

        // Add missing columns to leads table
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                if (!Schema::hasColumn('leads', 'client_id')) {
                    $table->unsignedBigInteger('client_id')->nullable()->after('id');
                    $table->index('client_id');
                }
                if (!Schema::hasColumn('leads', 'project_id')) {
                    $table->unsignedBigInteger('project_id')->nullable()->after('client_id');
                    $table->index('project_id');
                }
                if (!Schema::hasColumn('leads', 'task_id')) {
                    $table->unsignedBigInteger('task_id')->nullable()->after('project_id');
                    $table->index('task_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove columns from proposals table
        if (Schema::hasTable('proposals')) {
            Schema::table('proposals', function (Blueprint $table) {
                if (Schema::hasColumn('proposals', 'client_id')) {
                    $table->dropColumn('client_id');
                }
                if (Schema::hasColumn('proposals', 'project_id')) {
                    $table->dropColumn('project_id');
                }
                if (Schema::hasColumn('proposals', 'task_id')) {
                    $table->dropColumn('task_id');
                }
            });
        }

        // Remove columns from leads table
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                if (Schema::hasColumn('leads', 'client_id')) {
                    $table->dropColumn('client_id');
                }
                if (Schema::hasColumn('leads', 'project_id')) {
                    $table->dropColumn('project_id');
                }
                if (Schema::hasColumn('leads', 'task_id')) {
                    $table->dropColumn('task_id');
                }
            });
        }
    }
};