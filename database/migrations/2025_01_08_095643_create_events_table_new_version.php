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
        Schema::dropIfExists('events');
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('date');
            $table->dateTime('due_date')->nullable();
            $table->string('type')->default('allday')->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->index('date');
            $table->index(['referable_id', 'referable_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
