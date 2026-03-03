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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('task_id')->index(); // Updated 'taskId' to 'task_id' for naming convention consistency
            $table->unsignedInteger('number');
            $table->integer('reference'); // Corrected 'referance' to 'reference'
            $table->dateTime('date')->index();
            $table->dateTime('expire_date'); // Updated 'expireDate' to 'expire_date' for naming convention consistency
            $table->string('currency', 10);
            $table->string('payment_currency', 10); // Updated 'paymentCurrency' to 'payment_currency' for naming convention consistency
            $table->string('sale_agent', 50); // Updated 'saleAgent' to 'sale_agent' for naming convention consistency
            $table->string('discount_type', 20)->nullable(); // Updated 'discountType' to 'discount_type' for naming convention consistency
            $table->string('status', 10);
            $table->string('admin_note', 1024)->nullable(); // Updated 'adminNote' to 'admin_note' for naming convention consistency
            $table->string('client_note', 1024)->nullable(); // Updated 'clientNote' to 'client_note' for naming convention consistency
            $table->json('tax')->nullable();
            $table->decimal('adjustment', 12, 2)->default(0)->nullable();
            $table->boolean('is_discount_percentage')->default(true)->nullable(); // Updated 'discountPercentage' to 'is_discount_percentage' for clarity
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('task_id')->index(); // Updated 'taskId' to 'task_id' for naming convention consistency
            $table->unsignedInteger('number');
            $table->boolean('is_repeated')->default(false)->nullable(); // Updated 'isRepeated' to 'is_repeated' for naming convention consistency
            $table->string('repeat_every')->nullable(); // Updated 'repeatEvery' to 'repeat_every' for naming convention consistency
            $table->integer('repeat_counter')->nullable(); // Updated 'repeatCounter' to 'repeat_counter' for naming convention consistency
            $table->dateTime('date')->index(); // Updated 'invoiceDate' to 'date' for naming convention consistency
            $table->dateTime('due_date')->nullable(); // Updated 'dueDate' to 'due_date' for naming convention consistency
            $table->string('currency', 10);
            $table->string('payment_currency', 10); // Updated 'paymentCurrency' to 'payment_currency' for naming convention consistency
            $table->string('sale_agent', 50); // Updated 'saleAgent' to 'sale_agent' for naming convention consistency
            $table->string('discount_type', 20)->nullable(); // Updated 'discountType' to 'discount_type' for naming convention consistency
            $table->string('status', 10);
            $table->string('admin_note', 1024)->nullable(); // Updated 'adminNote' to 'admin_note' for naming convention consistency
            $table->string('client_note', 1024)->nullable(); // Updated 'clientNote' to 'client_note' for naming convention consistency
            $table->json('tax')->nullable();
            $table->decimal('adjustment', 12, 2)->default(0);
            $table->boolean('is_discount_percentage')->default(true)->nullable(); // Updated 'discountPercentage' to 'is_discount_percentage' for clarity
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('task_id')->index(); // Updated 'taskId' to 'task_id' for naming convention consistency
            $table->string('subject', 255);
            $table->string('type', 100);
            $table->dateTime('date')->index();
            $table->unsignedBigInteger('client_id')->nullable()->index(); // Added client_id
            $table->integer('reference'); // Corrected 'referance' to 'reference'
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10);
            $table->string('payment_method', 10)->nullable(); // Updated 'paymentMethod' to 'payment_method' for naming convention consistency
            $table->json('tax')->nullable();
            $table->boolean('is_repeated')->default(false)->nullable(); // Updated 'isRepeated' to 'is_repeated' for naming convention consistency
            $table->string('repeat_every', 10)->nullable(); // Updated 'repeatEvery' to 'repeat_every' for naming convention consistency
            $table->integer('repeat_counter')->nullable(); // Updated 'repeatCounter' to 'repeat_counter' for naming convention consistency
            $table->boolean('have_package')->default(false);
            $table->date('package_date')->nullable(); // Updated 'packageDate' to 'package_date' for naming convention consistency
            $table->string('package_number', 10)->nullable(); // Updated 'packageNumber' to 'package_number' for naming convention consistency
            $table->decimal('total_balance', 12, 2)->nullable(); // Updated 'totalBalance' to 'total_balance' for naming convention consistency
            $table->string('note', 1024)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Updated foreign key to match new column name
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('task_id')->index(); // Updated 'taskId' to 'task_id' for naming convention consistency
            $table->unsignedInteger('invoice_number'); // Updated 'InvoiceNumber' to 'invoice_number' for naming convention consistency
            $table->decimal('amount', 12, 2);
            $table->dateTime('payment_date')->index(); // Updated 'paymentDate' to 'payment_date' for naming convention consistency
            $table->string('payment_mode', 20); // Updated 'paymentMode' to 'payment_mode' for naming convention consistency
            $table->string('payment_method', 20)->nullable(); // Updated 'paymentMethod' to 'payment_method' for naming convention consistency
            $table->string('transaction_id', 50)->nullable(); // Updated 'transactionId' to 'transaction_id' for naming convention consistency
            $table->string('note', 1024)->nullable();
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
        });

        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Updated 'userId' to 'user_id' for naming convention consistency
            $table->unsignedBigInteger('task_id')->index(); // Updated 'taskId' to 'task_id' for naming convention consistency
            $table->unsignedInteger('number');
            $table->boolean('is_repeated')->default(false)->nullable(); // Updated 'isRepeated' to 'is_repeated' for naming convention consistency
            $table->string('repeat_every')->nullable(); // Updated 'repeatEvery' to 'repeat_every' for naming convention consistency
            $table->integer('repeat_counter')->nullable(); // Updated 'repeatCounter' to 'repeat_counter' for naming convention consistency
            $table->dateTime('date')->index();
            $table->dateTime('due_date')->nullable(); // Updated 'dueDate' to 'due_date' for naming convention consistency
            $table->string('currency', 10);
            $table->string('payment_currency', 10); // Updated 'paymentCurrency' to 'payment_currency' for naming convention consistency
            $table->string('sale_agent', 50); // Updated 'saleAgent' to 'sale_agent' for naming convention consistency
            $table->string('discount_type', 20)->nullable(); // Updated 'discountType' to 'discount_type' for naming convention consistency
            $table->string('status', 10);
            $table->string('admin_note', 1024)->nullable(); // Updated 'adminNote' to 'admin_note' for naming convention consistency
            $table->string('client_note', 1024)->nullable(); // Updated 'clientNote' to 'client_note' for naming convention consistency
            $table->json('tax')->nullable();
            $table->decimal('adjustment', 12, 2)->default(0);
            $table->boolean('is_discount_percentage')->default(true)->nullable(); // Updated 'discountPercentage' to 'is_discount_percentage' for clarity
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Updated foreign key to match new column name
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Updated foreign key to match new column name
        });

        ######################################## SUB TABLES

        Schema::create('finance_items', function (Blueprint $table) {
            $table->id();
            $table->morphs('referable'); // Polymorphic columns: referable_id and referable_type
            $table->string('description', 1024);
            $table->integer('qty')->default(1);
            $table->decimal('amount', 12, 2)->default(0);
            $table->json('tax'); // JSON for tax IDs
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['referable_id', 'referable_type']);
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('code', 5);
            $table->string('symbol', 5);
            $table->string('decimal_separator', 5); // Updated 'decimalSeparator' to 'decimal_separator' for naming convention consistency
            $table->string('thousand_separator', 5); // Updated 'thousandSeparator' to 'thousand_separator' for naming convention consistency
            $table->string('currency_placement', 20); // Updated 'currencyPlacement' to 'currency_placement' for naming convention consistency
            $table->timestamps();
        });

        Schema::create('payment_modes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 1024);
            $table->string('related', 20); // e.g., invoices only / expenses only
            $table->string('status', 20)->default('active'); // e.g., active / inactive
            $table->timestamps();
        });

        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 1024);
            $table->timestamps();
        });

        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 10);
            $table->decimal('rate', 3, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('credit_notes');
        Schema::dropIfExists('finance_items');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('payment_modes');
        Schema::dropIfExists('tax_rates');
        Schema::dropIfExists('expense_types');
    }
};
