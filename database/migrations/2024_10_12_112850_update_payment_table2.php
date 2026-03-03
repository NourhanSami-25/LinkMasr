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
        // Schema::table('payments', function (Blueprint $table) {
        //     $table->unsignedBigInteger('client_id')->nullable()->after('task_id');
        //     $table->unsignedBigInteger('invoice_id')->nullable()->after('client_id');
        //     $table->unsignedBigInteger('pymentRequest_id')->nullable()->after('invoice_id');
        //     $table->unsignedBigInteger('credit_note_id')->nullable()->after('pymentRequest_id');
        //     $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        //     $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        //     $table->foreign('credit_note_id')->references('id')->on('credit_notes')->onDelete('cascade');
        //     $table->foreign('pymentRequest_id')->references('id')->on('payment_requests')->onDelete('cascade');
        // });

         Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        // Schema::rename('payments', 'pyments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('payments', function (Blueprint $table) {
        //     // Drop foreign key constraints
        //     $table->dropForeign(['client_id']);
        //     $table->dropForeign(['invoice_id']);
        //     $table->dropForeign(['credit_note_id']);
        //     $table->dropForeign(['pymentRequest_id']);
            
        //     // Drop columns
        //     $table->dropColumn('client_id');
        //     $table->dropColumn('invoice_id');
        //     $table->dropColumn('credit_note_id');
        //     $table->dropColumn('pymentRequest_id');
        // });
        
    }
};
