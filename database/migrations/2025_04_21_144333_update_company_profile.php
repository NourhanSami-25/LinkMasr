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
            $table->string('currency', 10)->after('website');
            $table->string('city', 255)->nullable()->after('country');
            $table->string('country_code', 255)->nullable()->after('address');
            $table->string('zip_code', 50)->nullable()->after('currency');
            $table->string('pdf_profile', 255)->nullable()->after('bankAccount2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'city',
                'country_code',
                'zip_code',
                'pdf_profile'
            ]);
        });
    }
};
