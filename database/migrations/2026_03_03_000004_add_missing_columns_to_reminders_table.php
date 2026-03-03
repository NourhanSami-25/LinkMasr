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
        Schema::table('reminders', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('reminders', 'date')) {
                $table->dateTime('date')->nullable()->after('description');
            }
            if (!Schema::hasColumn('reminders', 'subject')) {
                $table->string('subject', 255)->nullable()->after('referable_id');
            }
            if (!Schema::hasColumn('reminders', 'priority')) {
                $table->string('priority', 50)->default('normal')->nullable()->after('date');
            }
            if (!Schema::hasColumn('reminders', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('event_reminded');
            }
            if (!Schema::hasColumn('reminders', 'repeat_every_type')) {
                $table->string('repeat_every_type', 50)->default('day')->nullable()->after('repeat_counter');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('reminders', 'date')) {
                $columnsToDrop[] = 'date';
            }
            if (Schema::hasColumn('reminders', 'subject')) {
                $columnsToDrop[] = 'subject';
            }
            if (Schema::hasColumn('reminders', 'priority')) {
                $columnsToDrop[] = 'priority';
            }
            if (Schema::hasColumn('reminders', 'created_by')) {
                $columnsToDrop[] = 'created_by';
            }
            if (Schema::hasColumn('reminders', 'repeat_every_type')) {
                $columnsToDrop[] = 'repeat_every_type';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
