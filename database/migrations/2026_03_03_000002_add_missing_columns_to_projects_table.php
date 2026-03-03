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
        Schema::table('projects', function (Blueprint $table) {
            // Add subject column (alias for name)
            if (!Schema::hasColumn('projects', 'subject')) {
                $table->string('subject', 255)->nullable()->after('client_id');
            }
            
            // Add date column (alias for start_date)
            if (!Schema::hasColumn('projects', 'date')) {
                $table->dateTime('date')->nullable()->after('description');
            }
            
            // Add due_date if not exists (already exists as deadline_date)
            if (!Schema::hasColumn('projects', 'due_date')) {
                $table->dateTime('due_date')->nullable()->after('date');
            }
            
            // Add is_repeated column
            if (!Schema::hasColumn('projects', 'is_repeated')) {
                $table->boolean('is_repeated')->default(false)->after('billing_type');
            }
            
            // Add repeat_every column
            if (!Schema::hasColumn('projects', 'repeat_every')) {
                $table->string('repeat_every', 10)->nullable()->after('is_repeated');
            }
            
            // Add repeat_counter column
            if (!Schema::hasColumn('projects', 'repeat_counter')) {
                $table->integer('repeat_counter')->nullable()->after('repeat_every');
            }
            
            // Add assignees column
            if (!Schema::hasColumn('projects', 'assignees')) {
                $table->json('assignees')->nullable()->after('repeat_counter');
            }
            
            // Add followers column
            if (!Schema::hasColumn('projects', 'followers')) {
                $table->json('followers')->nullable()->after('assignees');
            }
            
            // Add created_by column
            if (!Schema::hasColumn('projects', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('followers');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $columns = ['subject', 'date', 'due_date', 'is_repeated', 'repeat_every', 'repeat_counter', 'assignees', 'followers', 'created_by'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
