<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('vacation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('vacation_type', 50); // Updated 'vacationType' to 'vacation_type' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date'); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->json('follower')->nullable();
            $table->json('handover')->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approverId' to 'approver_id' for naming convention consistency
            $table->string('approver_name', 100); // Updated 'approverName' to 'approver_name' for naming convention consistency
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('permission_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date'); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->json('follower')->nullable();
            $table->json('handover')->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approverId' to 'approver_id' for naming convention consistency
            $table->string('approver_name', 100); // Updated 'approverName' to 'approver_name' for naming convention consistency
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('mission_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('task_name', 255); // Updated 'taskName' to 'task_name' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date'); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->json('follower')->nullable();
            $table->json('handover')->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approverId' to 'approver_id' for naming convention consistency
            $table->string('approver_name', 100); // Updated 'approverName' to 'approver_name' for naming convention consistency
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('money_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('task_name', 255); // Updated 'taskName' to 'task_name' for naming convention consistency
            $table->decimal('amount', 10, 2);
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('due_date'); // Updated 'dueDate' to 'due_date' for naming convention consistency
            $table->json('follower')->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approverId' to 'approver_id' for naming convention consistency
            $table->string('approver_name', 100); // Updated 'approverName' to 'approver_name' for naming convention consistency
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('task_name', 255); // Updated 'taskName' to 'task_name' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date'); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->json('follower')->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approverId' to 'approver_id' for naming convention consistency
            $table->string('approver_name', 100); // Updated 'approverName' to 'approver_name' for naming convention consistency
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('support_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approverId' to 'approver_id' for naming convention consistency
            $table->string('approver_name', 100); // Updated 'approverName' to 'approver_name' for naming convention consistency
            $table->json('handover')->nullable();
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('work_home_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'user_id' for consistency
            $table->string('task_name', 255); // Updated 'taskName' to 'task_name' for naming convention consistency
            $table->string('subject', 255);
            $table->string('description', 1024)->nullable();
            $table->dateTime('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->dateTime('end_date'); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->json('follower')->nullable();
            $table->unsignedBigInteger('approver_id')->index(); // Updated 'approver_id' for consistency, changed type to match user_id
            $table->string('approver_name', 100); // Updated 'approver_name' for consistency
            $table->string('status', 10)->default('waiting')->index();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('approval_records', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 255);
            $table->string('related_request', 50);
            $table->string('department', 50);
            $table->string('role', 50);
            $table->unsignedBigInteger('followup_id')->index();
            $table->string('followup_name', 50);
            $table->unsignedBigInteger('approver_id')->index();
            $table->string('approver_name', 50);
            $table->integer('days_to_sign')->default(100);
            $table->timestamps();
        });
        
    }

    
    
    public function down(): void
    {
        Schema::dropIfExists('vacation_requests');
        Schema::dropIfExists('permission_requests');
        Schema::dropIfExists('mission_requests');
        Schema::dropIfExists('money_requests');
        Schema::dropIfExists('overtime_requests');
        Schema::dropIfExists('support_requests');
        Schema::dropIfExists('work_home_requests');
        Schema::dropIfExists('approval_records');
    }
};
