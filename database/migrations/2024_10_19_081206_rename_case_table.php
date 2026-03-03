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
        // Drop case_activities table
        Schema::dropIfExists('case_activities');

        // Drop case_updates table
        Schema::dropIfExists('case_updates');

        // Drop cases table
        Schema::dropIfExists('cases');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
