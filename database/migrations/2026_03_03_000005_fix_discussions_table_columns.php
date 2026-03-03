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

        if (Schema::hasTable('discussions')) {
            // For SQLite, we need to recreate the table
            if ($isSQLite) {
                // Create a temporary table with the correct structure
                Schema::create('discussions_temp', function (Blueprint $table) {
                    $table->id();
                    $table->morphs('discussionable');
                    $table->index(['discussionable_id', 'discussionable_type']);
                    $table->timestamps();
                });

                // Copy data from old table to new table
                DB::statement('INSERT INTO discussions_temp (id, discussionable_type, discussionable_id, created_at, updated_at) 
                              SELECT id, referable_type, referable_id, created_at, updated_at FROM discussions');

                // Drop old table
                Schema::dropIfExists('discussions');

                // Rename temp table to discussions
                Schema::rename('discussions_temp', 'discussions');
            } else {
                // For other databases, we can rename columns directly
                if (Schema::hasColumn('discussions', 'referable_type') && !Schema::hasColumn('discussions', 'discussionable_type')) {
                    Schema::table('discussions', function (Blueprint $table) {
                        $table->renameColumn('referable_type', 'discussionable_type');
                    });
                }

                if (Schema::hasColumn('discussions', 'referable_id') && !Schema::hasColumn('discussions', 'discussionable_id')) {
                    Schema::table('discussions', function (Blueprint $table) {
                        $table->renameColumn('referable_id', 'discussionable_id');
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if we're using SQLite
        $isSQLite = DB::connection()->getDriverName() === 'sqlite';

        if (Schema::hasTable('discussions')) {
            if ($isSQLite) {
                // Create a temporary table with the old structure
                Schema::create('discussions_temp', function (Blueprint $table) {
                    $table->id();
                    $table->string('referable_type')->nullable();
                    $table->unsignedBigInteger('referable_id')->nullable();
                    $table->text('description')->nullable();
                    $table->boolean('visible_to_client')->default(false);
                    $table->string('username')->nullable();
                    $table->timestamps();
                });

                // Copy data back
                DB::statement('INSERT INTO discussions_temp (id, referable_type, referable_id, created_at, updated_at) 
                              SELECT id, discussionable_type, discussionable_id, created_at, updated_at FROM discussions');

                // Drop new table
                Schema::dropIfExists('discussions');

                // Rename temp table
                Schema::rename('discussions_temp', 'discussions');
            } else {
                if (Schema::hasColumn('discussions', 'discussionable_type') && !Schema::hasColumn('discussions', 'referable_type')) {
                    Schema::table('discussions', function (Blueprint $table) {
                        $table->renameColumn('discussionable_type', 'referable_type');
                    });
                }

                if (Schema::hasColumn('discussions', 'discussionable_id') && !Schema::hasColumn('discussions', 'referable_id')) {
                    Schema::table('discussions', function (Blueprint $table) {
                        $table->renameColumn('discussionable_id', 'referable_id');
                    });
                }
            }
        }
    }
};
