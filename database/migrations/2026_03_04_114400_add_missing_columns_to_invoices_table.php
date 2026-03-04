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
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'discount_amount_type')) {
                $table->string('discount_amount_type', 20)->default('percentage')->after('discount_type');
            }
            if (!Schema::hasColumn('invoices', 'fixed_discount')) {
                $table->decimal('fixed_discount', 12, 2)->default(0)->after('discount');
            }
            if (!Schema::hasColumn('invoices', 'items_tax_value')) {
                $table->decimal('items_tax_value', 12, 2)->default(0)->after('tax');
            }
            if (!Schema::hasColumn('invoices', 'overall_tax_value')) {
                $table->decimal('overall_tax_value', 12, 2)->default(0)->after('items_tax_value');
            }
            if (!Schema::hasColumn('invoices', 'total_discount')) {
                $table->decimal('total_discount', 12, 2)->default(0)->after('overall_tax_value');
            }
            if (!Schema::hasColumn('invoices', 'percentage_discount_value')) {
                $table->decimal('percentage_discount_value', 12, 2)->default(0)->after('total_discount');
            }
            if (!Schema::hasColumn('invoices', 'total_tax')) {
                $table->decimal('total_tax', 12, 2)->default(0)->after('percentage_discount_value');
            }
            if (!Schema::hasColumn('invoices', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('total_tax');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $columns = ['discount_amount_type', 'fixed_discount', 'items_tax_value', 'overall_tax_value', 'total_discount', 'percentage_discount_value', 'total_tax', 'subtotal'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};