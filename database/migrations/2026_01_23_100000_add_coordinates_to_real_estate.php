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
        Schema::table('property_units', function (Blueprint $table) {
            $table->decimal('pos_x', 5, 2)->nullable()->after('drawing_id'); // Percentage 0-100
            $table->decimal('pos_y', 5, 2)->nullable()->after('pos_x');
        });

        Schema::table('project_drawings', function (Blueprint $table) {
            $table->decimal('pos_x', 5, 2)->nullable()->after('parent_id'); // Percentage 0-100 (position on parent)
            $table->decimal('pos_y', 5, 2)->nullable()->after('pos_x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_drawings', function (Blueprint $table) {
            $table->dropColumn(['pos_x', 'pos_y']);
        });

        Schema::table('property_units', function (Blueprint $table) {
            $table->dropColumn(['pos_x', 'pos_y']);
        });
    }
};
