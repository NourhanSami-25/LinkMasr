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
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('is_billed')->default(true)->after('type');
        });

        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('logo')->after('pdf_profile')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('is_billed');
        });
    
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }

};
