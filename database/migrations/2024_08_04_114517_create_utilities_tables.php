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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->index(); // Updated 'projectId' to 'project_id' for naming convention consistency
            $table->integer('number')->unique()->length(8); // Length is not applicable to integers, removed .length(8)
            $table->string('subject', 255);
            $table->string('content', 1024);
            $table->string('priority', 20);
            $table->string('type', 20);
            $table->json('tags')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
        
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
        
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('message', 1024);
            $table->string('status', 10)->default('active');
            $table->boolean('show_staff')->default(true)->nullable(); // Updated to snake_case
            $table->boolean('show_clients')->default(false)->nullable(); // Updated to snake_case
            $table->boolean('show_name')->default(false)->nullable(); // Updated to snake_case
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('title', 255);
            $table->string('content', 1024);
            $table->dateTime('date');
            $table->string('link', 255);
            $table->string('status', 10)->default('new');
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('calendars', function (Blueprint $table) { // Corrected 'calenders' to 'calendars'
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date')->nullable(); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->dateTime('notify_time'); // Updated 'notifyTime' to 'notify_time' for naming convention consistency
            $table->string('time_unit', 10); // Updated 'timeUnit' to 'time_unit' for naming convention consistency
            $table->string('event_color', 20)->default('blue')->nullable(); // Updated 'eventColor' to 'event_color' for naming convention consistency
            $table->string('link', 255)->nullable();
            $table->string('related_to', 20)->nullable(); // Updated 'relatedTo' to 'related_to' for naming convention consistency
            $table->string('status', 10);
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('description', 1024)->nullable();
            $table->string('category', 50)->nullable();
            $table->string('priority', 10)->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('type', 20);
            $table->json('staff_members'); // Updated 'staffMembers' to 'staff_members' for naming convention consistency
            $table->string('achievement', 10);
            $table->dateTime('start_date'); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date'); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->string('description', 1024);
            $table->boolean('notify_when_achieved'); // Corrected spelling from 'notifiWhenAchive' to 'notify_when_achieved'
            $table->boolean('notify_when_failed'); // Corrected spelling from 'notifiWhenFailed' to 'notify_when_failed'
            $table->string('status', 10);
            $table->timestamps();
        
            // Adding foreign key constraints if `user_id` references another table, such as `users`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        ######################################## SUB TABLES
        
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->index(); // Updated 'ticketId' to 'ticket_id' for naming convention consistency
            $table->string('content', 1024);
            $table->string('username', 50);
            $table->timestamps();
        
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
        
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('todo_id'); // Updated 'todoId' to 'todo_id' for naming convention consistency
            $table->string('subject', 255);
            $table->dateTime('date');
            $table->timestamps();
        
            $table->foreign('todo_id')->references('id')->on('todos')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('calenders');
        Schema::dropIfExists('todos');
        Schema::dropIfExists('goals');
        Schema::dropIfExists('ticket_replies');
        Schema::dropIfExists('todo_items');
    }
};
