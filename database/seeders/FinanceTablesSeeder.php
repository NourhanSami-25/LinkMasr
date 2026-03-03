<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FinanceTablesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Common helper for all tables
        $foreignKeys = [
            'project_id' => 1,
            'task_id' => 1,
            'client_id' => 1,
            'created_by' => 1,
        ];

        // 1️⃣ Expenses
        foreach (range(1, 20) as $i) {
            DB::table('expenses')->insert(array_merge($foreignKeys, [
                'client_name' => $faker->company,
                'billing_address' => $faker->address,
                'number' => $i,
                'is_repeated' => $faker->boolean(20),
                'repeat_every' => $faker->randomElement(['month', 'year', 'week']),
                'repeat_counter' => $faker->numberBetween(0, 5),
                'type' => $faker->word,
                'date' => $faker->dateTimeThisYear(),
                'currency' => $faker->randomElement(['USD', 'EUR', 'EGP']),
                'sale_agent' => $faker->name,
                'status' => $faker->randomElement(['draft', 'approved', 'paid']),
                'description' => $faker->sentence(10),
                'admin_note' => $faker->sentence(),
                'client_note' => $faker->sentence(),
                'discount_type' => 'before_tax',
                'discount_amount_type' => 'percentage',
                'tax' => json_encode(['VAT' => 14]),
                'items_tax_value' => $faker->randomFloat(2, 0, 100),
                'overall_tax_value' => $faker->randomFloat(2, 0, 100),
                'adjustment' => $faker->randomFloat(2, -50, 50),
                'discount' => $faker->randomFloat(2, 0, 100),
                'percentage_discount_value' => $faker->randomFloat(2, 0, 10),
                'fixed_discount' => $faker->randomFloat(2, 0, 100),
                'subtotal' => $faker->randomFloat(2, 100, 1000),
                'total_tax' => $faker->randomFloat(2, 10, 200),
                'total_discount' => $faker->randomFloat(2, 0, 100),
                'total' => $faker->randomFloat(2, 100, 2000),
                'payment_method' => $faker->randomElement(['cash', 'bank', 'card']),
                'have_package' => $faker->boolean(30),
                'package_date' => $faker->optional()->date(),
                'package_number' => $faker->optional()->numerify('PKG###'),
                'total_balance' => $faker->randomFloat(2, 0, 2000),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 2️⃣ Invoices
        foreach (range(1, 20) as $i) {
            DB::table('invoices')->insert(array_merge($foreignKeys, [
                'pymentRequest_id' => 1,
                'client_name' => $faker->company,
                'billing_address' => $faker->address,
                'number' => $i,
                'is_repeated' => $faker->boolean(20),
                'repeat_every' => $faker->word,
                'repeat_counter' => $faker->numberBetween(0, 5),
                'date' => $faker->date(),
                'due_date' => $faker->optional()->date(),
                'currency' => $faker->randomElement(['USD', 'EUR', 'EGP']),
                'sale_agent' => $faker->name,
                'status' => $faker->randomElement(['draft', 'sent', 'paid']),
                'send_status' => $faker->boolean(50),
                'description' => $faker->sentence(10),
                'admin_note' => $faker->sentence(),
                'client_note' => $faker->sentence(),
                'discount_type' => 'before_tax',
                'discount_amount_type' => 'percentage',
                'tax' => json_encode(['VAT' => 14]),
                'items_tax_value' => $faker->randomFloat(2, 0, 100),
                'overall_tax_value' => $faker->randomFloat(2, 0, 100),
                'adjustment' => $faker->randomFloat(2, -50, 50),
                'discount' => $faker->randomFloat(2, 0, 100),
                'percentage_discount_value' => $faker->randomFloat(2, 0, 10),
                'fixed_discount' => $faker->randomFloat(2, 0, 100),
                'subtotal' => $faker->randomFloat(2, 100, 1000),
                'total_tax' => $faker->randomFloat(2, 10, 200),
                'total_discount' => $faker->randomFloat(2, 0, 100),
                'total' => $faker->randomFloat(2, 100, 2000),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 3️⃣ Payment Requests
        foreach (range(1, 20) as $i) {
            DB::table('paymentrequests')->insert(array_merge($foreignKeys, [
                'client_name' => $faker->company,
                'billing_address' => $faker->address,
                'number' => $i,
                'date' => $faker->dateTimeThisYear(),
                'due_date' => $faker->optional()->dateTimeThisYear(),
                'currency' => $faker->randomElement(['USD', 'EUR', 'EGP']),
                'sale_agent' => $faker->name,
                'status' => $faker->randomElement(['pending', 'approved', 'paid']),
                'send_status' => $faker->boolean(50),
                'description' => $faker->sentence(10),
                'admin_note' => $faker->sentence(),
                'client_note' => $faker->sentence(),
                'discount_type' => 'before_tax',
                'discount_amount_type' => 'percentage',
                'tax' => json_encode(['VAT' => 14]),
                'items_tax_value' => $faker->randomFloat(2, 0, 100),
                'overall_tax_value' => $faker->randomFloat(2, 0, 100),
                'adjustment' => $faker->randomFloat(2, -50, 50),
                'discount' => $faker->randomFloat(2, 0, 100),
                'percentage_discount_value' => $faker->randomFloat(2, 0, 10),
                'fixed_discount' => $faker->randomFloat(2, 0, 100),
                'subtotal' => $faker->randomFloat(2, 100, 1000),
                'total_tax' => $faker->randomFloat(2, 10, 200),
                'total_discount' => $faker->randomFloat(2, 0, 100),
                'total' => $faker->randomFloat(2, 100, 2000),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 4️⃣ Payments
        foreach (range(1, 20) as $i) {
            DB::table('pyments')->insert(array_merge($foreignKeys, [
                'invoice_id' => 1,
                'pymentRequest_id' => 1,
                'creditNote_id' => 1,
                'expense_id' => 1,
                'related' => 'invoice',
                'client_name' => $faker->company,
                'number' => $i,
                'subject' => $faker->sentence(3),
                'total' => $faker->randomFloat(2, 100, 2000),
                'date' => $faker->date(),
                'currency' => $faker->randomElement(['USD', 'EUR', 'EGP']),
                'payment_mode' => $faker->randomElement(['bank', 'cash', 'online']),
                'payment_method' => $faker->randomElement(['transfer', 'card']),
                'transaction_number' => $faker->uuid,
                'note' => $faker->sentence(),
                'status' => $faker->randomElement(['paid', 'pending']),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 5️⃣ Credit Notes
        foreach (range(1, 20) as $i) {
            DB::table('creditnotes')->insert(array_merge($foreignKeys, [
                'invoice_id' => 1,
                'client_name' => $faker->company,
                'billing_address' => $faker->address,
                'number' => $i,
                'date' => $faker->date(),
                'due_date' => $faker->optional()->date(),
                'currency' => $faker->randomElement(['USD', 'EUR', 'EGP']),
                'sale_agent' => $faker->name,
                'status' => $faker->randomElement(['draft', 'sent', 'applied']),
                'description' => $faker->sentence(10),
                'admin_note' => $faker->sentence(),
                'client_note' => $faker->sentence(),
                'discount_type' => 'before_tax',
                'discount_amount_type' => 'percentage',
                'tax' => json_encode(['VAT' => 14]),
                'subtotal' => $faker->randomFloat(2, 100, 1000),
                'total' => $faker->randomFloat(2, 100, 2000),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
