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

        // 		  					
        Schema::table('expenses', function (Blueprint $table) {
            $table->integer('number')->after('client_id');
            $table->string('sale_agent' , 50)->nullable()->after('currency');
            $table->string('discount_type' , 50)->nullable()->default('before_tax')->after('sale_agent');
            $table->string('discount_amount_type' , 50)->nullable()->default('percentage')->after('discount_type');
            $table->string('tags' , 255)->nullable()->after('discount_amount_type');
            $table->string('description' , 1024)->nullable()->after('subject');
            $table->decimal('adjustment' , 12 , 2)->nullable()->default(0)->after('tax');
            $table->decimal('discount' , 12 , 2)->nullable()->default(0)->after('adjustment');
            $table->decimal('fixed_discount' , 12 , 2)->nullable()->default(0)->after('discount');
            $table->decimal('total' , 12 , 2)->nullable()->default(0)->after('fixed_discount');
        });

        // Schema::table('payment_requests', function (Blueprint $table) {
        //     $table->unsignedBigInteger('project_id')->nullable()->after('id');
        //     $table->unsignedBigInteger('client_id')->nullable()->after('task_id');
        //     $table->unsignedBigInteger('created_by')->nullable()->after('total');
        //     $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        //     $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['project_id']);
            $table->dropColumn('client_id');
            $table->dropColumn('project_id');
            $table->dropColumn('created_by');
        });

        // Schema::table('payment_requests', function (Blueprint $table) {
        //     $table->dropForeign(['client_id']);
        //     $table->dropForeign(['project_id']);
        //     $table->dropColumn('client_id');
        //     $table->dropColumn('project_id');
        //     $table->dropColumn('created_by');
        // });
    }
};
