<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateDBBeforeLunching extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0'); // Temporarily disable foreign key checks

        $tables = [
            'proposals',
            'leads',
            'expenses',
            // 'invoices',
            // 'tasks',
            // 'projects',
            // 'events',
            // // Add all tables you want to truncate
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1'); // Re-enable foreign key checks
    }
}
