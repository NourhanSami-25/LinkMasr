<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reminders', function (Blueprint $table) {

            // Drop unwanted columns
            $table->dropColumn(['notify_before', 'notify_before_type', 'is_public']);

            // Add new columns
            $table->integer('remind_before')->default(0)->after('date');
            $table->boolean('remind_at_event')->default(true)->after('remind_before');
            $table->boolean('before_reminded')->default(false)->after('remind_at_event');
            $table->boolean('event_reminded')->default(false)->after('before_reminded');
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
