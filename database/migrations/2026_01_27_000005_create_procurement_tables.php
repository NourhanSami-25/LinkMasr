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
        // طلبات الشراء
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('reference_no', 50)->unique();
            $table->date('date');
            $table->date('required_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'ordered'])->default('draft');
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->date('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('purchase_requests')->cascadeOnDelete();
            $table->foreignId('boq_id')->nullable()->constrained('construction_boqs')->nullOnDelete();
            $table->foreignId('breakdown_item_id')->nullable()->constrained('boq_breakdown_items')->nullOnDelete();
            $table->string('description');
            $table->string('unit', 20);
            $table->decimal('quantity', 12, 4);
            $table->decimal('estimated_price', 12, 2)->nullable();
            $table->timestamps();
        });

        // أوامر الشراء
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('request_id')->nullable()->constrained('purchase_requests')->nullOnDelete();
            $table->string('po_no', 50)->unique();
            $table->date('date');
            $table->date('delivery_date');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('vat_percentage', 5, 2)->default(0);
            $table->decimal('vat_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'sent', 'partial', 'received', 'cancelled'])->default('draft');
            $table->text('terms')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('pr_item_id')->nullable()->constrained('purchase_request_items')->nullOnDelete();
            $table->string('description');
            $table->string('unit', 20);
            $table->decimal('quantity', 12, 4);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 15, 2);
            $table->decimal('received_qty', 12, 4)->default(0);
            $table->timestamps();
        });

        // استلام المواد (GRN)
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_id')->constrained('purchase_orders');
            $table->foreignId('project_id')->constrained();
            $table->string('grn_no', 50)->unique();
            $table->date('date');
            $table->string('delivery_note')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('received_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_id')->constrained('goods_receipts')->cascadeOnDelete();
            $table->foreignId('po_item_id')->constrained('purchase_order_items');
            $table->decimal('received_qty', 12, 4);
            $table->decimal('accepted_qty', 12, 4);
            $table->decimal('rejected_qty', 12, 4)->default(0);
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
        Schema::dropIfExists('goods_receipts');
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_request_items');
        Schema::dropIfExists('purchase_requests');
    }
};
