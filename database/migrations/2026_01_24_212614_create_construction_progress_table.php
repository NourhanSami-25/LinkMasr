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
        if (!Schema::hasTable('construction_progress')) {
            Schema::create('construction_progress', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('boq_id')->index();
                $table->date('date')->index(); // Log Date
                $table->decimal('actual_quantity', 12, 2)->default(0); // Cumulative or Periodic? Let's assume Daily Log
                $table->string('status', 20)->default('pending'); // pending, approved
                $table->timestamps();

                $table->foreign('boq_id')->references('id')->on('construction_boqs')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_progress');
    }
};
