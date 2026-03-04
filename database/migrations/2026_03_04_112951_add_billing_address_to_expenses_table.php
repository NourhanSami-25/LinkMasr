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
        Schema::table('expenses', function (Blueprint $table) {
            // Add only the missing columns that are causing the error
            if (!Schema::hasColumn('expenses', 'billing_address')) {
                $table->string('billing_address')->nullable()->after('client_id');
            }
            if (!Schema::hasColumn('expenses', 'number')) {
                $table->unsignedInteger('number')->after('billing_address');
            }
            if (!Schema::hasColumn('expenses', 'client_name')) {
                $table->string('client_name')->nullable()->after('client_id');
            }
            if (!Schema::hasColumn('expenses', 'description')) {
                $table->text('description')->nullable()->after('type');
            }
            if (!Schema::hasColumn('expenses', 'status')) {
                $table->string('status', 50)->default('unpaid')->after('description');
            }
            if (!Schema::hasColumn('expenses', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('expenses', 'items_tax_value')) {
                $table->decimal('items_tax_value', 12, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('expenses', 'discount_type')) {
                $table->string('discount_type', 50)->nullable()->after('items_tax_value');
            }
            if (!Schema::hasColumn('expenses', 'discount_amount_type')) {
                $table->string('discount_amount_type', 50)->nullable()->after('discount_type');
            }
            if (!Schema::hasColumn('expenses', 'discount')) {
                $table->decimal('discount', 12, 2)->default(0)->after('discount_amount_type');
            }
            if (!Schema::hasColumn('expenses', 'fixed_discount')) {
                $table->decimal('fixed_discount', 12, 2)->default(0)->after('discount');
            }
            if (!Schema::hasColumn('expenses', 'overall_tax_value')) {
                $table->decimal('overall_tax_value', 12, 2)->default(0)->after('fixed_discount');
            }
            if (!Schema::hasColumn('expenses', 'total_discount')) {
                $table->decimal('total_discount', 12, 2)->default(0)->after('overall_tax_value');
            }
            if (!Schema::hasColumn('expenses', 'percentage_discount_value')) {
                $table->decimal('percentage_discount_value', 12, 2)->default(0)->after('total_discount');
            }
            if (!Schema::hasColumn('expenses', 'total_tax')) {
                $table->decimal('total_tax', 12, 2)->default(0)->after('percentage_discount_value');
            }
            if (!Schema::hasColumn('expenses', 'total')) {
                $table->decimal('total', 12, 2)->default(0)->after('total_tax');
            }
            if (!Schema::hasColumn('expenses', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('total');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn([
                'billing_address', 'number', 'client_name', 'description', 'status',
                'subtotal', 'items_tax_value', 'discount_type', 'discount_amount_type',
                'discount', 'fixed_discount', 'overall_tax_value', 'total_discount',
                'percentage_discount_value', 'total_tax', 'total', 'created_by'
            ]);
        });
    }
};