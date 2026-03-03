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
        // Tables already have correct names from erp.sql (paymentrequests, creditnotes)
        // Just add missing columns
        
        if (Schema::hasTable('paymentrequests')) {
            Schema::table('paymentrequests', function (Blueprint $table) {
                if (!Schema::hasColumn('paymentrequests', 'items_tax_value')) {
                    $table->decimal('items_tax_value', 12, 2)->default(0)->nullable()->after('tax');
                    $table->decimal('overall_tax_value', 12, 2)->default(0)->nullable()->after('items_tax_value');
                    $table->decimal('percentage_discount_value', 12, 2)->default(0)->nullable()->after('discount');
                    $table->decimal('subtotal', 12, 2)->default(0)->nullable()->after('fixed_discount');
                    $table->decimal('total_tax', 12, 2)->default(0)->nullable()->after('subtotal');
                    $table->decimal('total_discount', 12, 2)->default(0)->nullable()->after('total_tax');
                }
            });
        }

        if (Schema::hasTable('creditnotes')) {
            Schema::table('creditnotes', function (Blueprint $table) {
                if (!Schema::hasColumn('creditnotes', 'items_tax_value')) {
                    $table->decimal('items_tax_value', 12, 2)->default(0)->nullable()->after('tax');
                    $table->decimal('overall_tax_value', 12, 2)->default(0)->nullable()->after('items_tax_value');
                    $table->decimal('percentage_discount_value', 12, 2)->default(0)->nullable()->after('discount');
                    $table->decimal('subtotal', 12, 2)->default(0)->nullable()->after('fixed_discount');
                    $table->decimal('total_tax', 12, 2)->default(0)->nullable()->after('subtotal');
                    $table->decimal('total_discount', 12, 2)->default(0)->nullable()->after('total_tax');
                }
            });
        }

        // Add fields to expenses table
        if (Schema::hasTable('expenses')) {
            Schema::table('expenses', function (Blueprint $table) {
                if (!Schema::hasColumn('expenses', 'client_note')) {
                    $table->string('client_note', 1024)->nullable()->after('note');
                }
                if (!Schema::hasColumn('expenses', 'items_tax_value')) {
                    $table->decimal('items_tax_value', 12, 2)->default(0)->nullable()->after('tax');
                    $table->decimal('overall_tax_value', 12, 2)->default(0)->nullable()->after('items_tax_value');
                    $table->decimal('percentage_discount_value', 12, 2)->default(0)->nullable();
                    $table->decimal('subtotal', 12, 2)->default(0)->nullable();
                    $table->decimal('total_tax', 12, 2)->default(0)->nullable();
                    $table->decimal('total_discount', 12, 2)->default(0)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Rollback: rename back the tables
        Schema::rename('paymentRequests', 'payment_requests');
        Schema::rename('creditNotes', 'credit_notes');

        Schema::table('payment_requests', function (Blueprint $table) {
            $table->dropColumn([
                'items_tax_value',
                'overall_tax_value',
                'percentage_discount_value',
                'subtotal',
                'total_tax',
                'total_discount',
            ]);
        });

        Schema::table('credit_notes', function (Blueprint $table) {
            $table->dropColumn([
                'items_tax_value',
                'overall_tax_value',
                'percentage_discount_value',
                'subtotal',
                'total_tax',
                'total_discount',
            ]);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn([
                'client_note',
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
