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
        // مستخلصات مقاولي الباطن
        Schema::create('subcontractor_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcontract_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_no', 50);
            $table->integer('sequence_no');
            $table->date('period_from');
            $table->date('period_to');
            $table->decimal('gross_amount', 15, 2);
            $table->decimal('retention_amount', 15, 2);
            $table->decimal('advance_deduction', 15, 2)->default(0);
            $table->decimal('previous_payments', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'paid'])->default('draft');
            $table->foreignId('submitted_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->date('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // بنود مستخلص المقاول
        Schema::create('subcontractor_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('subcontractor_invoices')->cascadeOnDelete();
            $table->foreignId('subcontract_item_id')->constrained('subcontract_items');
            $table->decimal('previous_qty', 12, 4)->default(0);
            $table->decimal('current_qty', 12, 4);
            $table->decimal('cumulative_qty', 12, 4);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });

        // مستخلصات العملاء (Progress Claims)
        Schema::create('client_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('invoice_no', 50);
            $table->integer('sequence_no');
            $table->date('period_from');
            $table->date('period_to');
            $table->decimal('gross_amount', 15, 2);
            $table->decimal('retention_amount', 15, 2);
            $table->decimal('advance_deduction', 15, 2)->default(0);
            $table->decimal('previous_certified', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->decimal('vat_percentage', 5, 2)->default(0);
            $table->decimal('vat_amount', 15, 2)->default(0);
            $table->decimal('total_with_vat', 15, 2);
            $table->enum('status', ['draft', 'submitted', 'certified', 'invoiced', 'paid'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('certified_by')->nullable()->constrained('users');
            $table->date('certified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // بنود مستخلص العميل
        Schema::create('client_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('client_invoices')->cascadeOnDelete();
            $table->foreignId('boq_id')->constrained('construction_boqs');
            $table->decimal('previous_qty', 12, 4)->default(0);
            $table->decimal('current_qty', 12, 4);
            $table->decimal('cumulative_qty', 12, 4);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_invoice_items');
        Schema::dropIfExists('client_invoices');
        Schema::dropIfExists('subcontractor_invoice_items');
        Schema::dropIfExists('subcontractor_invoices');
    }
};
