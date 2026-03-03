<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_units', function (Blueprint $table) {
            if (!Schema::hasColumn('property_units', 'sold_date')) {
                $table->date('sold_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('property_units', 'buyer_id')) {
                $table->unsignedBigInteger('buyer_id')->nullable()->after('sold_date');
                $table->index('buyer_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('property_units', function (Blueprint $table) {
            if (Schema::hasColumn('property_units', 'sold_date')) {
                $table->dropColumn('sold_date');
            }
            if (Schema::hasColumn('property_units', 'buyer_id')) {
                $table->dropColumn('buyer_id');
            }
        });
    }
};
