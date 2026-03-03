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
        // الجدول الزمني الرئيسي
        Schema::create('project_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('version', 10)->default('1.0');
            $table->date('baseline_start');
            $table->date('baseline_end');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // مهام الجدول
        Schema::create('schedule_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('project_schedules')->cascadeOnDelete();
            $table->foreignId('boq_id')->nullable()->constrained('construction_boqs')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('schedule_tasks')->cascadeOnDelete();
            $table->string('wbs_code', 50)->nullable();
            $table->string('name');
            $table->date('planned_start');
            $table->date('planned_end');
            $table->date('actual_start')->nullable();
            $table->date('actual_end')->nullable();
            $table->decimal('planned_progress', 5, 2)->default(0);
            $table->decimal('actual_progress', 5, 2)->default(0);
            $table->decimal('weight', 5, 2)->default(0);
            $table->integer('duration_days')->default(0);
            $table->integer('sort_order')->default(0);
            $table->string('color', 20)->nullable();
            $table->timestamps();
        });

        // التبعيات
        Schema::create('schedule_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predecessor_id')->constrained('schedule_tasks')->cascadeOnDelete();
            $table->foreignId('successor_id')->constrained('schedule_tasks')->cascadeOnDelete();
            $table->enum('type', ['FS', 'FF', 'SS', 'SF'])->default('FS');
            $table->integer('lag_days')->default(0);
            $table->timestamps();
            
            $table->unique(['predecessor_id', 'successor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_dependencies');
        Schema::dropIfExists('schedule_tasks');
        Schema::dropIfExists('project_schedules');
    }
};
