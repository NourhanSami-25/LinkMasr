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
        // عمالة المشروع
        Schema::create('project_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('id_number', 20)->nullable();
            $table->string('job_title');
            $table->string('specialty')->nullable();
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('overtime_rate', 10, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('phone', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // سجل الحضور
        Schema::create('worker_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('project_workers')->cascadeOnDelete();
            $table->foreignId('boq_id')->nullable()->constrained('construction_boqs')->nullOnDelete();
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->decimal('hours_worked', 4, 2)->default(0);
            $table->decimal('overtime_hours', 4, 2)->default(0);
            $table->enum('status', ['present', 'absent', 'leave', 'holiday'])->default('present');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->unique(['worker_id', 'date']);
        });

        // توزيع الرواتب
        Schema::create('payroll_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_regular', 15, 2)->default(0);
            $table->decimal('total_overtime', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('payroll_distributions')->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained('project_workers');
            $table->integer('days_worked')->default(0);
            $table->decimal('overtime_hours', 6, 2)->default(0);
            $table->decimal('regular_amount', 12, 2);
            $table->decimal('overtime_amount', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
        Schema::dropIfExists('payroll_distributions');
        Schema::dropIfExists('worker_attendance');
        Schema::dropIfExists('project_workers');
    }
};
