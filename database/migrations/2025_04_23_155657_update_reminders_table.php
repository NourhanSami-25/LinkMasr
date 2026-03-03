<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reminders', function (Blueprint $table) {

            // Drop unwanted columns only if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('reminders', 'notify_before')) {
                $columnsToDrop[] = 'notify_before';
            }
            if (Schema::hasColumn('reminders', 'notify_before_type')) {
                $columnsToDrop[] = 'notify_before_type';
            }
            if (Schema::hasColumn('reminders', 'is_public')) {
                $columnsToDrop[] = 'is_public';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Add new columns only if they don't exist
            if (!Schema::hasColumn('reminders', 'remind_before')) {
                $table->integer('remind_before')->default(0)->after('date');
            }
            if (!Schema::hasColumn('reminders', 'remind_at_event')) {
                $table->boolean('remind_at_event')->default(true)->after('remind_before');
            }
            if (!Schema::hasColumn('reminders', 'before_reminded')) {
                $table->boolean('before_reminded')->default(false)->after('remind_at_event');
            }
            if (!Schema::hasColumn('reminders', 'event_reminded')) {
                $table->boolean('event_reminded')->default(false)->after('before_reminded');
            }
        });
    }

    public function down()
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Revert rename
            $table->renameColumn('remind_before', 'notify_before');

            // Restore dropped columns
            $table->string('notify_before_type', 50)->nullable()->default('minute')->after('notify_before');
            $table->boolean('is_public')->nullable()->default(0)->after('status');

            // Drop added columns
            $table->dropColumn(['remind_before', 'remind_at_event', 'before_reminded', 'event_reminded']);
        });
    }
};
