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
        Schema::table('files', function (Blueprint $table) {
            // Add missing columns that are used in FileService
            if (!Schema::hasColumn('files', 'description')) {
                $table->text('description')->nullable()->after('type');
            }
            if (!Schema::hasColumn('files', 'path')) {
                $table->string('path', 500)->nullable()->after('link');
            }
            if (!Schema::hasColumn('files', 'category')) {
                $table->string('category', 100)->nullable()->after('description');
            }
            if (!Schema::hasColumn('files', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('username');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['description', 'path', 'category', 'created_by']);
        });
    }
};