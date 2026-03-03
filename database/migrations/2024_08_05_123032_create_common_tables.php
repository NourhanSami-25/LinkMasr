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
        //    protected $fillable = ['referable_id', 'referable_type', 'name', 'type', 'link', 'user'];
        //     public function referable()
        // {
        //     return $this->morphTo();
        // }

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->string('content', 1024);
            $table->dateTime('date');
            $table->string('username', 50); // Consider adding a foreign key if username relates to a user table
            $table->timestamps();

            $table->index(['referable_id', 'referable_type']);
        });
        
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->string('name', 255);
            $table->string('type', 20);
            $table->string('link', 255);
            $table->string('username', 50); // Consider adding a foreign key if username relates to a user table
            $table->timestamps();

            $table->index(['referable_id', 'referable_type']);
        });
        
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->json('assigned_to'); // Updated 'assignedTo' to 'assigned_to' for naming convention consistency
            $table->boolean('is_repeated')->default(false); // Updated 'isRepeated' to 'is_repeated' for naming convention consistency
            $table->string('repeat_every', 10)->nullable(); // Updated 'repeatEvery' to 'repeat_every' for naming convention consistency
            $table->integer('repeat_counter')->nullable(); // Updated 'repeatCounter' to 'repeat_counter' for naming convention consistency
            $table->string('description', 1024);
            $table->string('status', 20)->default('pending'); // 'pending' / 'passed'
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['referable_id', 'referable_type']);
        });
        
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->string('subject', 255);
            $table->dateTime('date');
            $table->string('username', 50); // Consider adding a foreign key if username relates to a user table
            $table->timestamps();

            $table->index(['referable_id', 'referable_type']);
        });
        
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->string('description', 1024); // Added length to match other tables
            $table->boolean('visible_to_client')->default(false)->nullable(); // Updated 'visibleToClient' to 'visible_to_client' for naming convention consistency
            $table->string('username', 50); // Consider adding a foreign key if username relates to a user table
            $table->timestamps();

            $table->index(['referable_id', 'referable_type']);
        });
        
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->string('content', 1024);
            $table->string('username', 50); // Consider adding a foreign key if username relates to a user table
            $table->timestamps();

            $table->index(['referable_id', 'referable_type']);
        });
        
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });
        
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('type', 50);
            $table->timestamps();
        });
        
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discussion_id')->index(); // Updated 'discussionId' to 'discussion_id' for naming convention consistency
            $table->string('content', 1024);
            $table->string('username', 50); // Consider adding a foreign key if username relates to a user table
            $table->timestamps();
        
            // Adding foreign key constraint to link to discussions table
            $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('files');
        Schema::dropIfExists('reminders');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('discussion_replies');
    }
};
