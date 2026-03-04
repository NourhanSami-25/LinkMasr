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
        Schema::table('creditnotes', function (Blueprint $table) {
            // Add missing columns that are in the model fillable array but not in database
            if (!Schema::hasColumn('creditnotes', 'billing_address')) {
                $table->text('billing_address')->nullable();
            }
            if (!Schema::hasColumn('creditnotes', 'client_name')) {
                $table->string('client_name')->nullable();
            }
            if (!Schema::hasColumn('creditnotes', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('creditnotes', 'client_note')) {
                $table->text('client_note')->nullable();
            }
            if (!Schema::hasColumn('creditnotes', 'discount_amount_type')) {
                $table->string('discount_amount_type')->default('percentage');
            }
            if (!Schema::hasColumn('creditnotes', 'percentage_discount_value')) {
                $table->decimal('percentage_discount_value', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('creditnotes', 'total_discount')) {
                $table->decimal('total_discount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('creditnotes', 'total_tax')) {
                $table->decimal('total_tax', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('creditnotes', 'fixed_discount')) {
                $table->decimal('fixed_discount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('creditnotes', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
            }
            
            // Make some existing columns nullable if they exist
            if (Schema::hasColumn('creditnotes', 'task_id')) {
                $table->unsignedBigInteger('task_id')->nullable()->change();
            }
            if (Schema::hasColumn('creditnotes', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->change();
            }
            if (Schema::hasColumn('creditnotes', 'sale_agent')) {
                $table->unsignedBigInteger('sale_agent')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creditnotes', function (Blueprint $table) {
            // Drop the added columns
            $table->dropColumn([
                'billing_address',
                'client_name', 
                'description',
                'client_note',
                'discount_amount_type',
                'percentage_discount_value',
                'total_discount',
                'total_tax',
                'fixed_discount',
                'created_by'
            ]);
        });
    }
};
