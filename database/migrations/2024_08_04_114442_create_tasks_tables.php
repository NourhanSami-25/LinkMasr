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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('client_id'); // Updated 'clientId' to 'client_id' for naming convention consistency
            $table->string('name', 255);
            $table->string('description', 1024);
            $table->json('members')->nullable();
            $table->json('tags')->nullable();
            $table->dateTime('start_date'); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('deadline_date'); // Updated 'deadline' to 'deadline_date' for clarity in naming convention
            $table->integer('estimated_hours')->nullable(); // Updated 'estimatedHours' to 'estimated_hours' for naming convention consistency
            $table->string('billing_type', 20); // Updated 'billingType' to 'billing_type' for naming convention consistency
            $table->decimal('hour_rate', 12, 2)->default(0)->nullable(); // Updated 'hourRate' to 'hour_rate' for naming convention consistency
            $table->string('status', 20);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); // Updated foreign key to match new column name
        });
        
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('project_id')->nullable(); // Updated 'projectId' to 'project_id' for naming convention consistency
            $table->string('subject', 100);
            $table->string('status', 50);
            $table->dateTime('start_date'); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('due_date'); // Updated 'dueDate' to 'due_date' for naming convention consistency
            $table->string('priority', 10)->nullable();
            $table->decimal('hourly_rate', 12, 2)->default(0)->nullable(); // Updated 'hourlyRate' to 'hourly_rate' for naming convention consistency
            $table->boolean('is_billable')->default(true);
            $table->integer('logged_time')->nullable(); // Updated 'loggedTime' to 'logged_time' for naming convention consistency
            $table->string('related', 20);
            $table->string('description', 1024)->nullable();
            $table->string('type', 20);
            $table->json('tags')->nullable();
            $table->boolean('is_repeated')->default(false);
            $table->string('repeat_every', 10)->nullable(); // Updated 'repeatEvery' to 'repeat_every' for naming convention consistency
            $table->integer('repeat_counter')->nullable(); // Updated 'repeatCounter' to 'repeat_counter' for naming convention consistency
            $table->json('assignees')->nullable(); // Corrected typo in 'assignees'
            $table->json('followers')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade'); // Updated foreign key to match new column name
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('tasks');
    }
};
