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
        // Construction Materials Table
        Schema::create('construction_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit'); // متر مكعب، طن، كيس، إلخ
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Material Prices (Historical Tracking)
        Schema::create('material_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('construction_materials')->onDelete('cascade');
            $table->decimal('price', 12, 2);
            $table->date('date');
            $table->timestamps();
            
            $table->index(['material_id', 'date']);
        });

        // Cost Estimates
        Schema::create('cost_estimates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['land_construction', 'finishing']); // نوع التقدير
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id')->nullable(); // property_units
            $table->decimal('licensing_fees', 12, 2)->default(0);
            $table->decimal('other_fees', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        // Cost Estimate Items
        Schema::create('cost_estimate_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_id')->constrained('cost_estimates')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('construction_materials')->onDelete('cascade');
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_price', 12, 2); // Snapshot of price at time of estimate
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_estimate_items');
        Schema::dropIfExists('cost_estimates');
        Schema::dropIfExists('material_prices');
        Schema::dropIfExists('construction_materials');
    }
};
