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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slogan', 255)->nullable();
            $table->string('business', 255);
            $table->string('bio', 1024)->nullable();
            $table->string('type', 50);
            $table->string('email', 50);
            $table->string('email2', 50)->nullable();
            $table->string('supportEmail', 50)->nullable();
            $table->string('phone', 50);
            $table->string('phone2', 50)->nullable();
            $table->string('supportPhone', 50)->nullable();
            $table->string('country', 50);
            $table->string('address', 255);
            $table->string('address2', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('taxNumber', 50)->nullable();
            $table->string('registrationNumber', 50)->nullable();
            $table->date('registrationDate')->nullable();
            $table->string('bankAccount', 255)->nullable();
            $table->string('bankAccount2', 255)->nullable();
            $table->string('status', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
