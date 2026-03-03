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
        Schema::table('todos', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('todos', 'subject')) {
                $table->string('subject', 255)->after('user_id');
            }
            if (!Schema::hasColumn('todos', 'status')) {
                $table->string('status', 20)->default('pending')->after('priority');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            if (Schema::hasColumn('todos', 'subject')) {
                $table->dropColumn('subject');
            }
            if (Schema::hasColumn('todos', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
