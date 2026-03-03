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
        // الموردين/المقاولين
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 20)->default('supplier');  // supplier, subcontractor
            $table->string('tax_number', 50)->nullable();
            $table->string('commercial_register', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('iban')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // المناقصات
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('reference_no', 50)->unique();
            $table->string('title');
            $table->text('scope')->nullable();
            $table->date('issue_date');
            $table->date('closing_date');
            $table->enum('status', ['draft', 'open', 'closed', 'awarded', 'cancelled'])->default('draft');
            $table->foreignId('awarded_to')->nullable()->constrained('vendors')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // بنود المناقصة
        Schema::create('tender_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained()->cascadeOnDelete();
            $table->foreignId('boq_id')->nullable()->constrained('construction_boqs')->nullOnDelete();
            $table->string('description');
            $table->string('unit', 20);
            $table->decimal('quantity', 12, 4);
            $table->timestamps();
        });

        // عروض الأسعار
        Schema::create('tender_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->decimal('bid_amount', 15, 2);
            $table->date('bid_date');
            $table->date('validity_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['submitted', 'shortlisted', 'awarded', 'rejected'])->default('submitted');
            $table->timestamps();
        });

        // تفاصيل أسعار عروض المناقصات
        Schema::create('tender_bid_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bid_id')->constrained('tender_bids')->cascadeOnDelete();
            $table->foreignId('tender_item_id')->constrained('tender_items')->cascadeOnDelete();
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 15, 2);
            $table->timestamps();
        });

        // عقود مقاولي الباطن
        Schema::create('subcontracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('tender_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contract_no', 50)->unique();
            $table->string('title');
            $table->text('scope')->nullable();
            $table->decimal('contract_value', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('retention_percentage', 5, 2)->default(10);
            $table->decimal('advance_percentage', 5, 2)->default(0);
            $table->decimal('advance_paid', 15, 2)->default(0);
            $table->decimal('insurance_percentage', 5, 2)->default(0);
            $table->enum('status', ['draft', 'active', 'completed', 'suspended', 'terminated'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->text('terms')->nullable();
            $table->timestamps();
        });

        // بنود العقد (ربط بـ BOQ)
        Schema::create('subcontract_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcontract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('boq_id')->constrained('construction_boqs');
            $table->string('description')->nullable();
            $table->decimal('quantity', 12, 4);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 15, 2);
            $table->decimal('executed_qty', 12, 4)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcontract_items');
        Schema::dropIfExists('subcontracts');
        Schema::dropIfExists('tender_bid_items');
        Schema::dropIfExists('tender_bids');
        Schema::dropIfExists('tender_items');
        Schema::dropIfExists('tenders');
        Schema::dropIfExists('vendors');
    }
};
