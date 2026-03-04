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
        Schema::table('paymentrequests', function (Blueprint $table) {
            // Only add columns that don't exist yet
            if (!Schema::hasColumn('paymentrequests', 'billing_address')) {
                $table->text('billing_address')->nullable();
            }
            if (!Schema::hasColumn('paymentrequests', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('paymentrequests', 'discount_amount_type')) {
                $table->string('discount_amount_type')->nullable();
            }
            if (!Schema::hasColumn('paymentrequests', 'client_note')) {
                $table->text('client_note')->nullable();
            }
            if (!Schema::hasColumn('paymentrequests', 'discount_type')) {
                $table->string('discount_type')->nullable();
            }
            if (!Schema::hasColumn('paymentrequests', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'fixed_discount')) {
                $table->decimal('fixed_discount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'items_tax_value')) {
                $table->decimal('items_tax_value', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'percentage_discount_value')) {
                $table->decimal('percentage_discount_value', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'total_discount')) {
                $table->decimal('total_discount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'overall_tax_value')) {
                $table->decimal('overall_tax_value', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'total_tax')) {
                $table->decimal('total_tax', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('paymentrequests', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
            }
            if (!Schema::hasColumn('paymentrequests', 'client_name')) {
                $table->string('client_name')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paymentrequests', function (Blueprint $table) {
            $columns = [
                'billing_address',
                'description',
                'discount_amount_type',
                'client_note',
                'discount_type',
                'tax',
                'discount',
                'fixed_discount',
                'subtotal',
                'items_tax_value',
                'percentage_discount_value',
                'total_discount',
                'overall_tax_value',
                'total_tax',
                'created_by',
                'client_name'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('paymentrequests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
