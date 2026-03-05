<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workhome_requests', function (Blueprint $table) {
            $table->string('related_work', 255)->nullable()->after('related');
            $table->json('handover')->nullable()->after('follower');
        });
    }

    public function down(): void
    {
        Schema::table('workhome_requests', function (Blueprint $table) {
            $table->dropColumn('related_work');
            $table->dropColumn('handover');
        });
    }
};