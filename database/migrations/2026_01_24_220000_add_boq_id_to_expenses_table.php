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
        if (Schema::hasTable('expenses') && !Schema::hasColumn('expenses', 'boq_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->unsignedBigInteger('boq_id')->nullable()->after('id');
                $table->index('boq_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('expenses', 'boq_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropIndex(['boq_id']);
                $table->dropColumn('boq_id');
            });
        }
    }
};
