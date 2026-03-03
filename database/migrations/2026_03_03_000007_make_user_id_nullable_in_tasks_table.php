<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if we're using SQLite
        $isSQLite = DB::connection()->getDriverName() === 'sqlite';

        if (Schema::hasTable('tasks')) {
            if ($isSQLite) {
                // For SQLite, we need to use raw SQL to modify the column
                // First, check if user_id column exists and is NOT NULL
                $columns = Schema::getColumnListing('tasks');
                if (in_array('user_id', $columns)) {
                    // SQLite doesn't support ALTER COLUMN, so we'll just ensure it accepts NULL values
                    // by not enforcing the constraint in new inserts
                    DB::statement('PRAGMA foreign_keys=off');
                    
                    // Create new table with nullable user_id
                    DB::statement('CREATE TABLE tasks_new AS SELECT * FROM tasks');
                    DB::statement('DROP TABLE tasks');
                    
                    // Recreate with proper schema
                    Schema::create('tasks', function (Blueprint $table) {
                        $table->id();
                        $table->unsignedBigInteger('user_id')->nullable();
                        $table->unsignedBigInteger('project_id')->nullable();
                        $table->string('subject');
                        $table->string('status');
                        $table->dateTime('start_date')->nullable();
                        $table->dateTime('due_date')->nullable();
                        $table->string('priority')->nullable();
                        $table->decimal('hourly_rate', 10, 2)->nullable();
                        $table->boolean('is_billable')->default(false);
                        $table->integer('logged_time')->nullable();
                        $table->string('related')->nullable();
                        $table->text('description')->nullable();
                        $table->string('type')->nullable();
                        $table->text('tags')->nullable();
                        $table->boolean('is_repeated')->default(false);
                        $table->string('repeat_every')->nullable();
                        $table->integer('repeat_counter')->nullable();
                        $table->text('assignees')->nullable();
                        $table->text('followers')->nullable();
                        $table->timestamps();
                        $table->unsignedBigInteger('client_id')->nullable();
                        $table->unsignedBigInteger('created_by')->nullable();
                        $table->boolean('is_billed')->default(false);
                        $table->unsignedBigInteger('boq_id')->nullable();
                        $table->dateTime('date')->nullable();
                    });
                    
                    // Copy data back
                    DB::statement('INSERT INTO tasks SELECT * FROM tasks_new');
                    DB::statement('DROP TABLE tasks_new');
                    
                    DB::statement('PRAGMA foreign_keys=on');
                }
            } else {
                // For other databases
                Schema::table('tasks', function (Blueprint $table) {
                    if (Schema::hasColumn('tasks', 'user_id')) {
                        $table->unsignedBigInteger('user_id')->nullable()->change();
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
        // We won't reverse this as making it NOT NULL again could cause data loss
    }
};
