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
        // First, let's check if we have an Administrator role
        $adminRole = DB::table('roles')->where('name', 'Administrator')->first();
        
        if (!$adminRole) {
            // Create Administrator role if it doesn't exist
            $adminRoleId = DB::table('roles')->insertGetId([
                'name' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $adminRoleId = $adminRole->id;
        }
        
        // Get the admin user (ID: 3)
        $adminUser = DB::table('users')->where('id', 3)->first();
        
        if ($adminUser) {
            // Update the user's role_id to point to Administrator role
            DB::table('users')->where('id', 3)->update([
                'role_id' => $adminRoleId,
                'updated_at' => now(),
            ]);
            
            // Check if the user-role relationship exists in pivot table
            $existingRelation = DB::table('role_user')
                ->where('user_id', 3)
                ->where('role_id', $adminRoleId)
                ->first();
                
            if (!$existingRelation) {
                // Create the user-role relationship with full access
                DB::table('role_user')->insert([
                    'user_id' => 3,
                    'role_id' => $adminRoleId,
                    'access_level' => 'full',
                ]);
            }
        }
        
        // Create a balance record for the admin user if it doesn't exist
        $currentYear = date('Y');
        $existingBalance = DB::table('balances')
            ->where('user_id', 3)
            ->where('year', $currentYear)
            ->first();
        
        if (!$existingBalance) {
            DB::table('balances')->insert([
                'user_id' => 3,
                'year' => $currentYear,
                'total_days' => 30,
                'used_days' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the user-role relationship
        DB::table('role_user')->where('user_id', 3)->delete();
        
        // Remove the balance record
        DB::table('balances')
            ->where('user_id', 3)
            ->where('year', date('Y'))
            ->delete();
    }
};