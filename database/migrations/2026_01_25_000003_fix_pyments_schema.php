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
        if (Schema::hasTable('pyments')) {
            
            // 1. Rename columns (Separate block to ensure execution before using them)
            Schema::table('pyments', function (Blueprint $table) {
                if (Schema::hasColumn('pyments', 'invoice_number') && !Schema::hasColumn('pyments', 'number')) {
                    $table->renameColumn('invoice_number', 'number');
                }
                if (Schema::hasColumn('pyments', 'amount') && !Schema::hasColumn('pyments', 'total')) {
                    $table->renameColumn('amount', 'total');
                }
                if (Schema::hasColumn('pyments', 'payment_date') && !Schema::hasColumn('pyments', 'date')) {
                    $table->renameColumn('payment_date', 'date');
                }
                if (Schema::hasColumn('pyments', 'transaction_id') && !Schema::hasColumn('pyments', 'transaction_number')) {
                    $table->renameColumn('transaction_id', 'transaction_number');
                }
            });

            // 2. Ensure base columns exist (if renames failed or columns missing)
             Schema::table('pyments', function (Blueprint $table) {
                 if (!Schema::hasColumn('pyments', 'number')) {
                     $table->integer('number')->default(0); // Add default temporarily
                 }
                 if (!Schema::hasColumn('pyments', 'total')) {
                     $table->decimal('total', 12, 2)->default(0);
                 }
                 if (!Schema::hasColumn('pyments', 'date')) {
                     $table->date('date')->nullable();
                 }
                 if (!Schema::hasColumn('pyments', 'transaction_number')) {
                     $table->string('transaction_number', 50)->nullable();
                 }
             });

            // 3. Add missing columns (Now safe to use 'number' etc)
            Schema::table('pyments', function (Blueprint $table) {
                if (!Schema::hasColumn('pyments', 'invoice_id')) {
                    $table->unsignedBigInteger('invoice_id')->nullable()->after('client_id');
                }
                if (!Schema::hasColumn('pyments', 'pymentRequest_id')) {
                    $table->unsignedBigInteger('pymentRequest_id')->nullable()->after('invoice_id');
                }
                if (!Schema::hasColumn('pyments', 'creditNote_id')) {
                    $table->unsignedBigInteger('creditNote_id')->nullable()->after('pymentRequest_id');
                }
                if (!Schema::hasColumn('pyments', 'expense_id')) {
                    $table->unsignedBigInteger('expense_id')->nullable()->after('creditNote_id');
                }
                if (!Schema::hasColumn('pyments', 'related')) {
                    $table->string('related', 50)->nullable()->default('invoice');
                }
                if (!Schema::hasColumn('pyments', 'client_name')) {
                    $table->string('client_name', 255)->nullable();
                }
                if (!Schema::hasColumn('pyments', 'subject')) {
                    // Start check for positioning
                    if (Schema::hasColumn('pyments', 'number')) {
                        $table->string('subject', 255)->nullable()->after('number');
                    } else {
                        $table->string('subject', 255)->nullable();
                    }
                }
                if (!Schema::hasColumn('pyments', 'currency')) {
                     if (Schema::hasColumn('pyments', 'date')) {
                        $table->string('currency', 50)->nullable()->after('date');
                     } else {
                         $table->string('currency', 50)->nullable();
                     }
                }
                 if (!Schema::hasColumn('pyments', 'status')) {
                    $table->string('status', 50)->nullable()->default('paid');
                }
            });
            
             // 4. Final adjustments
             Schema::table('pyments', function (Blueprint $table) {
                 if (Schema::hasColumn('pyments', 'number')) {
                     $table->integer('number')->change();
                 }
                 if (Schema::hasColumn('pyments', 'date')) {
                     $table->date('date')->change();
                 }
             });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // No simple down
    }
};
