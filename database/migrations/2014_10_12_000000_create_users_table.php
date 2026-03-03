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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id')->index(); // Updated 'managerId' to 'manager_id' for naming convention consistency
            $table->string('name', 50);
            $table->string('email', 50)->nullable();
            $table->string('status', 10)->default('active');
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
        
            // Add a unique constraint to the 'name' column
            $table->unique('name');
        });
        
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        
            // Add a unique constraint to the 'name' column
            $table->unique('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('email', 50)->unique();
            $table->string('password', 255); // Length set to 255 for password
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('department_id')->index();
            $table->unsignedBigInteger('position_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->string('status', 20)->default('active'); // Length adjusted
            $table->rememberToken();
            $table->timestamps();
        
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }


    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
