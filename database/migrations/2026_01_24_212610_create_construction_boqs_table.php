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
        Schema::create('construction_boqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->index();
            $table->string('code', 50)->index(); // Item Code (e.g. 0028-004)
            $table->string('item_description', 1024);
            $table->string('unit', 20); // m3, ton, etc.
            $table->decimal('quantity', 12, 2)->default(0); // Budgeted Qty
            $table->decimal('unit_price', 12, 2)->default(0); // Budgeted Unit Rate
            $table->decimal('total_price', 15, 2)->default(0); // BAC (Budget at Completion)
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_boqs');
    }
};
