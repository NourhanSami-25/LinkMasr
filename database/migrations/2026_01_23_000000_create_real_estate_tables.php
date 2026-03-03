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
        // 1. Update expenses table
        if (Schema::hasTable('expenses') && !Schema::hasColumn('expenses', 'category')) {
            Schema::table('expenses', function (Blueprint $table) {
                // 'operational' (default, deducted from revenue), 'capital' (added to capital/investment)
                $table->string('category', 20)->default('operational')->after('total')->nullable();
            });
        }


        // 2. Create project_partner pivot table
        Schema::create('project_partner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('partner_id'); // References users.id
            $table->decimal('share_percentage', 5, 2)->default(0); // e.g. 20.00
            $table->decimal('management_fee_percentage', 5, 2)->default(0); // e.g. 5.00
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['project_id', 'partner_id']);
        });

        // 3. Create project_drawings table
        Schema::create('project_drawings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('title');
            $table->string('file_path'); // Path to the file in storage
            $table->string('type', 20)->default('general'); // master_plan, unit_plan, 3d_view, etc.
            $table->unsignedBigInteger('parent_id')->nullable(); // For hierarchy (Unit plan -> belongs to Master plan)
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('project_drawings')->onDelete('cascade');
        });

        // 4. Create property_units table
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name', 50); // Unit 101, Apt 4B
            $table->string('status', 20)->default('available'); // available, sold, reserved
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('area', 10, 2)->nullable(); // Sq meters
            $table->unsignedBigInteger('drawing_id')->nullable(); // Link to a specific drawing if needed
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('drawing_id')->references('id')->on('project_drawings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_units');
        Schema::dropIfExists('project_drawings');
        Schema::dropIfExists('project_partner');

        if (Schema::hasColumn('expenses', 'category')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};
