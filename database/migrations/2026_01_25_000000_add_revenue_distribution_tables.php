<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add expense_type to expenses table
        Schema::table('expenses', function (Blueprint $table) {
            $table->enum('expense_type', ['capital', 'revenue'])->default('capital')->after('category');
            $table->boolean('affects_breakeven')->default(true)->after('expense_type');
        });

        // Partner withdrawals
        Schema::create('partner_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Revenue distributions (header)
        Schema::create('revenue_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->date('distribution_date');
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->decimal('total_capital_expenses', 15, 2)->default(0);
            $table->decimal('total_revenue_expenses', 15, 2)->default(0);
            $table->decimal('total_management_fees', 15, 2)->default(0);
            $table->decimal('distributable_amount', 15, 2)->default(0);
            $table->boolean('breakeven_reached')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Revenue distribution items (details per partner)
        Schema::create('revenue_distribution_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribution_id')->constrained('revenue_distributions')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('users')->onDelete('cascade');
            $table->decimal('capital_share_percentage', 5, 2);
            $table->decimal('management_fee_percentage', 5, 2);
            $table->decimal('share_amount', 15, 2)->default(0);
            $table->decimal('management_fee_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revenue_distribution_items');
        Schema::dropIfExists('revenue_distributions');
        Schema::dropIfExists('partner_withdrawals');
        
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['expense_type', 'affects_breakeven']);
        });
    }
};
