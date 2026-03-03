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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('photo', 255)->nullable()->after('status');
            $table->string('phone2', 50)->nullable()->after('photo');
            $table->string('website', 255)->nullable()->after('phone2');
            $table->string('bio', 1024)->nullable()->after('website');
            $table->string('tax_number', 50)->nullable()->after('bio');
            $table->string('computer_number', 20)->nullable()->after('tax_number');
            $table->string('poa_number', 20)->nullable()->after('computer_number');
            $table->datetime('poa_expire_date')->nullable()->after('poa_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'photo',
                'phone2',
                'website',
                'bio',
                'tax_number',
                'computer_number',
                'poa_number',
                'poa_expire_date',
            ]);
        });
    }
};
