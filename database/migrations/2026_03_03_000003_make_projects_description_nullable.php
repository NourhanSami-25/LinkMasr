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
        // For SQLite, we can't easily change column types
        // The column will work fine as string(1024) for our purposes
        // Just skip this migration for SQLite
        if (config('database.default') === 'sqlite') {
            return;
        }
        
        Schema::table('projects', function (Blueprint $table) {
            $table->string('description', 1024)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'sqlite') {
            return;
        }
        
        Schema::table('projects', function (Blueprint $table) {
            $table->string('description', 1024)->nullable(false)->change();
        });
    }
};
