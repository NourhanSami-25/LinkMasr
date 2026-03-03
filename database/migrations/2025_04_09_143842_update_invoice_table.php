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
            $table->decimal('items_tax_value', 12)->default(0)->nullable()->after('tax');
            $table->decimal('overall_tax_value', 12)->default(0)->nullable()->after('items_tax_value');
            $table->decimal('percentage_discount_value', 12)->default(0)->nullable()->after('discount');
            $table->decimal('subtotal', 12)->default(0)->nullable()->after('fixed_discount');
            $table->decimal('total_tax', 12)->default(0)->nullable()->after('subtotal');
            $table->decimal('total_discount', 12)->default(0)->nullable()->after('total_tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'items_tax_value',
                'overall_tax_value',
                'percentage_discount_value',
                'subtotal',
                'total_tax',
                'total_discount',
            ]);
        });
    }
};
