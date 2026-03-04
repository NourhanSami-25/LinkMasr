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
        Schema::table('events', function (Blueprint $table) {
            $table->time('time')->nullable()->after('date');
            $table->time('due_time')->nullable()->after('due_date');
            $table->boolean('is_allday')->default(false)->nullable()->after('due_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['time', 'due_time', 'is_allday']);
        });
    }
};