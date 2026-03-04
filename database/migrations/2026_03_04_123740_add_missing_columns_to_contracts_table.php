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
        Schema::table('contracts', function (Blueprint $table) {
            // Add missing columns that the model expects (excluding client_id and unit_id which already exist)
            if (!Schema::hasColumn('contracts', 'number')) {
                $table->string('number')->nullable()->after('id');
            }
            if (!Schema::hasColumn('contracts', 'client_name')) {
                $table->string('client_name')->nullable()->after('project_id');
            }
            if (!Schema::hasColumn('contracts', 'currency')) {
                $table->string('currency', 10)->default('EGP')->after('type');
            }
            if (!Schema::hasColumn('contracts', 'sale_agent')) {
                $table->unsignedBigInteger('sale_agent')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('contracts', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('sale_agent');
            }
            if (!Schema::hasColumn('contracts', 'total')) {
                $table->decimal('total', 15, 2)->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('contracts', 'date')) {
                $table->date('date')->nullable()->after('total');
            }
            if (!Schema::hasColumn('contracts', 'due_date')) {
                $table->date('due_date')->nullable()->after('date');
            }
        });
        
        // Add foreign key constraints in a separate schema call to avoid conflicts
        Schema::table('contracts', function (Blueprint $table) {
            // Add foreign key constraints only if columns exist and constraints don't exist
            if (Schema::hasColumn('contracts', 'client_id')) {
                try {
                    $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist
                }
            }
            if (Schema::hasColumn('contracts', 'sale_agent')) {
                try {
                    $table->foreign('sale_agent')->references('id')->on('users')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist
                }
            }
            if (Schema::hasColumn('contracts', 'created_by')) {
                try {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Drop foreign keys first (if they exist)
            try {
                $table->dropForeign(['client_id']);
            } catch (Exception $e) {}
            try {
                $table->dropForeign(['sale_agent']);
            } catch (Exception $e) {}
            try {
                $table->dropForeign(['created_by']);
            } catch (Exception $e) {}
        });
        
        Schema::table('contracts', function (Blueprint $table) {
            // Drop columns (excluding client_id and unit_id which were added by other migrations)
            $columnsToRemove = [];
            if (Schema::hasColumn('contracts', 'number')) {
                $columnsToRemove[] = 'number';
            }
            if (Schema::hasColumn('contracts', 'client_name')) {
                $columnsToRemove[] = 'client_name';
            }
            if (Schema::hasColumn('contracts', 'currency')) {
                $columnsToRemove[] = 'currency';
            }
            if (Schema::hasColumn('contracts', 'sale_agent')) {
                $columnsToRemove[] = 'sale_agent';
            }
            if (Schema::hasColumn('contracts', 'created_by')) {
                $columnsToRemove[] = 'created_by';
            }
            if (Schema::hasColumn('contracts', 'total')) {
                $columnsToRemove[] = 'total';
            }
            if (Schema::hasColumn('contracts', 'date')) {
                $columnsToRemove[] = 'date';
            }
            if (Schema::hasColumn('contracts', 'due_date')) {
                $columnsToRemove[] = 'due_date';
            }
            
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};