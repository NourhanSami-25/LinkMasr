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
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'type')) {
                $table->string('type', 20)->nullable()->after('id');
            }
            if (!Schema::hasColumn('clients', 'status')) {
                $table->string('status', 10)->default('active')->after('default_language');
            }
            if (!Schema::hasColumn('clients', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('clients', 'photo')) {
                $table->string('photo', 255)->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('clients', 'phone2')) {
                $table->string('phone2', 20)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('clients', 'website')) {
                $table->string('website', 255)->nullable()->after('email');
            }
            if (!Schema::hasColumn('clients', 'bio')) {
                $table->string('bio', 1024)->nullable()->after('website');
            }
            if (!Schema::hasColumn('clients', 'tax_number')) {
                $table->string('tax_number', 10)->nullable()->after('bio');
            }
            if (!Schema::hasColumn('clients', 'computer_number')) {
                $table->string('computer_number', 20)->nullable()->after('tax_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $columns = ['type', 'status', 'created_by', 'photo', 'phone2', 'website', 'bio', 'tax_number', 'computer_number'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('clients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
