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
        
        
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('bio', 1024)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->decimal('hourly_rate', 12, 2)->nullable(); // Updated 'hourlyRate' to 'hourly_rate' for naming convention consistency
            $table->json('accountant_record')->nullable(); // Updated 'accountantRecord' to 'accountant_record' for naming convention consistency
            $table->string('photo', 255)->nullable();
            $table->dateTime('last_login')->nullable(); // Updated 'lastLogin' to 'last_login' for naming convention consistency
            $table->string('job_title', 50)->nullable(); // Updated 'jobTitle' to 'job_title' for naming convention consistency
            $table->string('position_title', 50)->nullable(); // Updated 'positionTitle' to 'position_title' for naming convention consistency
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        ######################################## SUB TABLES
        
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        
            // Add a unique constraint to the 'name' column
            $table->unique('name');
        });
        
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        
            // Add a unique constraint to the 'name' column
            $table->unique('name');
        });
        
        
        Schema::create('position_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id')->index(); // Updated 'positionId' to 'position_id' for naming convention consistency
            $table->unsignedBigInteger('permission_profile_id')->index(); // Updated 'permissionProfileId' to 'permission_profile_id' for naming convention consistency
        
            $table->unique('position_id'); // Ensure uniqueness on 'position_id'
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('permission_profile_id')->references('id')->on('permission_profiles')->onDelete('cascade');
        });
        
        Schema::create('department_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->index(); // Updated 'departmentId' to 'department_id' for naming convention consistency
            
            // Boolean columns for viewing different sections
            $table->boolean('view_project')->default(true);
            $table->boolean('view_task')->default(true);
            $table->boolean('view_client')->default(true);
            $table->boolean('view_payment_request')->default(true);
            $table->boolean('view_invoice')->default(true);
            $table->boolean('view_payment')->default(true);
            $table->boolean('view_credit_note')->default(true);
            $table->boolean('view_expense')->default(true);
            $table->boolean('view_request')->default(true);
            $table->boolean('view_contract')->default(true);
            $table->boolean('view_proposal')->default(true);
            $table->boolean('view_lead')->default(true);
            $table->boolean('view_utility')->default(true);
            $table->boolean('view_report')->default(true);
            $table->boolean('view_staff')->default(true);
            $table->boolean('view_hr')->default(true);
            $table->boolean('view_settings')->default(true);
            $table->timestamps();
        
            $table->unique('department_id'); // Ensure uniqueness on 'department_id'
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade'); // Updated foreign key to match new column name
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_profiles');

        Schema::dropIfExists('sections');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permission_profiles');
        Schema::dropIfExists('position_permissions');
        Schema::dropIfExists('department_sections');
    }
};
