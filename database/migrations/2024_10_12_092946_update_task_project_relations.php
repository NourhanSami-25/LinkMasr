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
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('status');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('project_id');
            $table->unsignedBigInteger('created_by')->nullable()->after('followers');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        // For the projects table
        Schema::table('projects', function (Blueprint $table) {
            // Drop the created_by column
            $table->dropColumn('created_by');
        });
    
        // For the tasks table
        Schema::table('tasks', function (Blueprint $table) {
            // First drop the foreign key constraint
            $table->dropForeign(['client_id']);
    
            // Then drop the client_id and created_by columns
            $table->dropColumn(['client_id', 'created_by']);
        });
    }
    
};
