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
        // مخزون المشروع
        Schema::create('project_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('item_code', 50);
            $table->string('description');
            $table->string('unit', 20);
            $table->decimal('quantity', 12, 4)->default(0);
            $table->decimal('average_cost', 12, 2)->default(0);
            $table->decimal('min_level', 12, 4)->default(0);
            $table->timestamps();
            
            $table->unique(['project_id', 'item_code']);
        });

        // حركات المخزون
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('project_inventory')->cascadeOnDelete();
            $table->enum('type', ['receipt', 'issue', 'transfer_in', 'transfer_out', 'adjustment']);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->decimal('quantity', 12, 4);
            $table->decimal('unit_cost', 12, 2);
            $table->date('date');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        // طلبات صرف المواد
        Schema::create('material_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('boq_id')->nullable()->constrained('construction_boqs')->nullOnDelete();
            $table->string('reference_no', 50)->unique();
            $table->date('date');
            $table->enum('status', ['draft', 'pending', 'approved', 'issued'])->default('draft');
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('material_issue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('material_issues')->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained('project_inventory');
            $table->decimal('requested_qty', 12, 4);
            $table->decimal('issued_qty', 12, 4)->default(0);
            $table->timestamps();
        });

        // تحويلات المخزون بين المشاريع
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_project_id')->constrained('projects');
            $table->foreignId('to_project_id')->constrained('projects');
            $table->string('reference_no', 50)->unique();
            $table->date('date');
            $table->enum('status', ['draft', 'pending', 'approved', 'transferred'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('inventory_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('inventory_transfers')->cascadeOnDelete();
            $table->foreignId('from_inventory_id')->constrained('project_inventory');
            $table->decimal('quantity', 12, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfer_items');
        Schema::dropIfExists('inventory_transfers');
        Schema::dropIfExists('material_issue_items');
        Schema::dropIfExists('material_issues');
        Schema::dropIfExists('inventory_transactions');
        Schema::dropIfExists('project_inventory');
    }
};
