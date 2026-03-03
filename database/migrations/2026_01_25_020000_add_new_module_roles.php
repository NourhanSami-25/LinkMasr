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
        // Determine which column name to use
        $columnName = Schema::hasColumn('roles', 'name') ? 'name' : 'subject';
        
        // Check if timestamps exist
        $hasTimestamps = Schema::hasColumn('roles', 'created_at');
        
        // Add new roles for the new modules
        $roleNames = ['construction', 'partners', 'real_estate', 'evm'];
        
        foreach ($roleNames as $roleName) {
            // Check if role already exists
            $exists = DB::table('roles')->where($columnName, $roleName)->exists();
            if (!$exists) {
                $roleData = [$columnName => $roleName];
                if ($hasTimestamps) {
                    $roleData['created_at'] = now();
                    $roleData['updated_at'] = now();
                }
                DB::table('roles')->insert($roleData);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columnName = Schema::hasColumn('roles', 'name') ? 'name' : 'subject';
        DB::table('roles')->whereIn($columnName, ['construction', 'partners', 'real_estate', 'evm'])->delete();
    }
};
