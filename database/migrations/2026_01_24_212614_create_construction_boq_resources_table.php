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
        if (!Schema::hasTable('construction_boq_resources')) {
            Schema::create('construction_boq_resources', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('boq_id')->index();
                $table->string('type', 50); // Material, Labor, Equipment, Subcontractor
                $table->string('description', 255);
                $table->decimal('consumption_rate', 10, 4)->default(0); // e.g. 0.35 tons per m3
                $table->decimal('unit_cost', 12, 2)->default(0); // Cost per resource unit
                $table->timestamps();

                $table->foreign('boq_id')->references('id')->on('construction_boqs')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_boq_resources');
    }
};
