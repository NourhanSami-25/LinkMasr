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
        Schema::table('company_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('company_profiles', 'enable_construction')) {
                $table->boolean('enable_construction')->default(true)->after('logo');
            }
            if (!Schema::hasColumn('company_profiles', 'enable_partners')) {
                $table->boolean('enable_partners')->default(true)->after('enable_construction');
            }
            if (!Schema::hasColumn('company_profiles', 'enable_real_estate')) {
                $table->boolean('enable_real_estate')->default(true)->after('enable_partners');
            }
            if (!Schema::hasColumn('company_profiles', 'default_management_fee')) {
                $table->decimal('default_management_fee', 5, 2)->default(10.00)->after('enable_real_estate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn(['enable_construction', 'enable_partners', 'enable_real_estate', 'default_management_fee']);
        });
    }
};
