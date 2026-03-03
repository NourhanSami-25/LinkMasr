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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name', 255);
            $table->string('phone', 20);
            $table->string('email', 50)->index();
            $table->string('currency', 10); // Corrected spelling
            $table->string('default_language', 10)->default('arabic');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->index(); // Renamed to snake_case
            $table->string('logo', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('phone2', 20)->nullable(); // Adjusted length for phone number
            $table->string('website', 255)->nullable();
            $table->string('bio', 1024)->nullable();
            $table->string('tax_number', 10)->nullable(); // Renamed to snake_case
            $table->string('computer_number', 20)->nullable(); // Renamed to snake_case
            $table->string('poa_number', 20)->nullable(); // Renamed to snake_case
            $table->dateTime('poa_expire_date')->nullable(); // Renamed to snake_case
            $table->json('groups')->nullable();
            $table->json('admins')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });


        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->index(); // Renamed to snake_case
            $table->string('country', 50);
            $table->string('state', 50)->nullable();
            $table->string('city', 50);
            $table->string('street_name', 50); // Renamed to snake_case
            $table->string('street_number', 10)->nullable(); // Renamed to snake_case
            $table->string('building_number', 10)->nullable(); // Renamed to snake_case
            $table->string('floor_number', 10)->nullable(); // Renamed to snake_case
            $table->string('unit_number', 10)->nullable(); // Renamed to snake_case
            $table->string('zip_code', 10)->nullable(); // Renamed to snake_case
            $table->string('status', 10)->default('active');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });


        Schema::create('billing_addresses', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('client_id')->index(); // Foreign key to clients table

            // Nullable fields for various bank and account details
            $table->string('bank_name', 100)->nullable(); // Bank name
            $table->string('address', 100)->nullable(); // Billing address
            $table->string('le_account', 100)->nullable(); // Local currency account
            $table->string('le_iban', 100)->nullable(); // Local IBAN
            $table->string('le_swift_code', 100)->nullable(); // Local Swift code
            $table->string('us_account', 100)->nullable(); // USD account
            $table->string('us_iban', 100)->nullable(); // USD IBAN
            $table->string('us_swift_code', 100)->nullable(); // USD Swift code

            // Status field with a default value
            $table->string('status', 10)->default('active'); // Status: active or inactive

            // Timestamps for created at and updated at
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });


        Schema::create('client_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->index(); // Renamed to snake_case
            $table->string('name', 50);
            $table->string('email', 255); // Increased length to 255 characters
            $table->string('phone', 20)->nullable();
            $table->string('position', 20)->nullable();
            $table->boolean('is_primary')->default(true); // Renamed to snake_case
            $table->string('status', 10)->default('active');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('client_profiles');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('billing_addresses');
        Schema::dropIfExists('client_contacts');
    }
};
