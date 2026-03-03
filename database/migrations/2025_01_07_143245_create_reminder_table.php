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
        if (!Schema::hasTable('reminders')) {
            Schema::create('reminders', function (Blueprint $table) {
                $table->id();
                $table->morphs('referable');
                $table->index(['referable_id', 'referable_type']);
                $table->string('subject', 255)->nullable();
                $table->string('description', 5000)->nullable();
                $table->dateTime('date');
                $table->integer('notify_before')->default(30)->nullable();
                $table->string('notify_before_type', 50)->default('minute')->nullable();
                $table->string('priority', 50)->default('normal')->nullable();
                $table->string('status', 50)->default('active')->nullable();
                $table->boolean('is_public')->default(false)->nullable();
                $table->boolean('is_repeated')->default(false)->nullable();
                $table->integer('repeat_every')->default(1)->nullable();
                $table->string('repeat_every_type', 50)->default('day')->nullable();
                $table->json('members')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->index('date');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
