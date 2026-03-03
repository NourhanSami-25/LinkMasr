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
        // For SQLite, we can't change column types easily
        // Skip this migration if using SQLite or if column is already text
        if (config('database.default') === 'sqlite') {
            // SQLite doesn't support changing column types well
            // The column will work fine as enum or text for our purposes
            return;
        }
        
        Schema::table('role_user', function (Blueprint $table) {
            $table->text('access_level')->change(); // Store multiple permissions as JSON or CSV
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
        
        Schema::table('role_user', function (Blueprint $table) {
            $table->string('access_level')->change(); // Store multiple permissions as string
        });
    }
};
