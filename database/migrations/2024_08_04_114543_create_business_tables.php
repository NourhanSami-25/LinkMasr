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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('project_id')->index(); // Updated 'projectId' to 'project_id' for naming convention consistency
            $table->string('subject', 255);
            $table->decimal('value', 12, 2);
            $table->string('type', 50);
            $table->date('start_date')->index(); // Updated 'startDate' to 'start_date' for naming convention consistency
            $table->date('end_date')->nullable(); // Updated 'endDate' to 'end_date' for naming convention consistency
            $table->string('description', 1024)->nullable();
            $table->string('content', 3000)->nullable();
            $table->string('signature', 20)->default('not signed')->nullable();
            $table->boolean('visible_to_client')->default(true); // Updated 'visibleToClient' to 'visible_to_client' for naming convention consistency
            $table->boolean('is_trashed')->default(false)->nullable(); // Updated 'isTrashed' to 'is_trashed' for naming convention consistency
            $table->string('status', 20);
            $table->timestamps();
        
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('client_id')->index(); // Updated 'clientId' to 'client_id' for naming convention consistency
            $table->string('name', 255);
            $table->string('position', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->decimal('lead_value', 12, 2)->default(0)->nullable(); // Updated 'leadValue' to 'lead_value' for naming convention consistency
            $table->string('source', 20)->index();
            $table->json('assigned')->nullable();
            $table->json('tags')->nullable();
            $table->dateTime('created_since')->nullable(); // Updated 'createdSince' to 'created_since' for naming convention consistency
            $table->boolean('is_public')->default(false)->nullable(); // Updated 'isPublic' to 'is_public' for naming convention consistency
            $table->string('description', 1024)->nullable();
            $table->string('status', 20);
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
        
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('client_id')->index(); // Updated 'clientId' to 'client_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('related', 20);
            $table->date('date')->index();
            $table->date('open_till')->nullable(); // Updated 'openTill' to 'open_till' for naming convention consistency
            $table->string('currency', 10);
            $table->string('discount_type', 20)->nullable(); // Updated 'discountType' to 'discount_type' for naming convention consistency
            $table->string('payment_currency', 10); // Updated 'paymentCurrency' to 'payment_currency' for naming convention consistency
            $table->json('tags')->nullable();
            $table->json('assigned')->nullable();
            $table->string('message', 1024)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->string('status', 20);
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
        
        ######################################## SUB TABLES
        
        Schema::create('contract_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('contract_types');
    }
};
