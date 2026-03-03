<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sales Contracts
        Schema::create('sales_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('property_units')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->decimal('total_price', 15, 2);
            $table->decimal('down_payment', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->integer('installment_months')->default(0);
            $table->date('contract_date');
            $table->date('delivery_date')->nullable();
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Payment Schedules
        Schema::create('payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('sales_contracts')->onDelete('cascade');
            $table->integer('installment_number');
            $table->decimal('amount', 15, 2);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Link payments to contracts
        Schema::table('pyments', function (Blueprint $table) {
            $table->foreignId('contract_id')->nullable()->after('project_id')->constrained('sales_contracts')->onDelete('set null');
            $table->foreignId('schedule_id')->nullable()->after('contract_id')->constrained('payment_schedules')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pyments', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
            $table->dropForeign(['schedule_id']);
            $table->dropColumn(['contract_id', 'schedule_id']);
        });
        
        Schema::dropIfExists('payment_schedules');
        Schema::dropIfExists('sales_contracts');
    }
};
