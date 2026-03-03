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
        // المعدات
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->string('category', 50);
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('plate_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 15, 2)->default(0);
            $table->decimal('current_value', 15, 2)->default(0);
            $table->decimal('depreciation_rate', 5, 2)->default(0);
            $table->decimal('daily_rate', 12, 2)->default(0);
            $table->decimal('hourly_rate', 12, 2)->default(0);
            $table->enum('status', ['available', 'in_use', 'maintenance', 'disposed'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // تخصيص المعدات للمشاريع
        Schema::create('equipment_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('boq_id')->nullable()->constrained('construction_boqs')->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('hours_used', 8, 2)->default(0);
            $table->decimal('estimated_cost', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // سجل استخدام المعدات
        Schema::create('equipment_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('equipment_assignments')->cascadeOnDelete();
            $table->date('date');
            $table->decimal('hours', 6, 2);
            $table->decimal('fuel_consumption', 8, 2)->nullable();
            $table->text('work_description')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('logged_by')->constrained('users');
            $table->timestamps();
        });

        // صيانة المعدات
        Schema::create('equipment_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('type', ['preventive', 'corrective', 'breakdown'])->default('preventive');
            $table->string('description');
            $table->decimal('cost', 12, 2)->default(0);
            $table->string('vendor_name')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
        Schema::dropIfExists('equipment_usage_logs');
        Schema::dropIfExists('equipment_assignments');
        Schema::dropIfExists('equipment');
    }
};
