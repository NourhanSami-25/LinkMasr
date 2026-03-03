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
        // Add new roles for the new modules
        $newRoles = [
            ['subject' => 'construction', 'created_at' => now(), 'updated_at' => now()],
            ['subject' => 'partners', 'created_at' => now(), 'updated_at' => now()],
            ['subject' => 'real_estate', 'created_at' => now(), 'updated_at' => now()],
            ['subject' => 'evm', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        foreach ($newRoles as $role) {
            // Check if role already exists
            $exists = DB::table('roles')->where('subject', $role['subject'])->exists();
            if (!$exists) {
                DB::table('roles')->insert($role);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->whereIn('subject', ['construction', 'partners', 'real_estate', 'evm'])->delete();
    }
};
