<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // جدول فئات التحليل
        Schema::create('boq_breakdown_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);        // MAT, EQP, LAB, SUB, OVH
            $table->string('name');            // Materials, Equipment, Labor...
            $table->string('name_ar');         // مواد، معدات، عمالة...
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // إدخال الفئات الافتراضية
        DB::table('boq_breakdown_categories')->insert([
            ['code' => 'MAT', 'name' => 'Materials', 'name_ar' => 'المواد', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LAB', 'name' => 'Labor & Workmanship', 'name_ar' => 'العمالة والمصنعيات', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'EQP', 'name' => 'Equipment', 'name_ar' => 'المعدات', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SUB', 'name' => 'Subcontractor', 'name_ar' => 'مقاولي الباطن', 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'OVH', 'name' => 'Overhead', 'name_ar' => 'مصاريف عامة', 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // جدول عناصر التحليل
        Schema::create('boq_breakdown_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boq_id')->constrained('construction_boqs')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('boq_breakdown_categories');
            $table->string('item_code', 50)->nullable();
            $table->string('description');
            $table->string('unit', 20);
            $table->decimal('quantity', 12, 4);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boq_breakdown_items');
        Schema::dropIfExists('boq_breakdown_categories');
    }
};
