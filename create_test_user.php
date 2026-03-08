<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create test task
try {
    DB::statement('PRAGMA foreign_keys = OFF');
    
    // Create a task for testing
    DB::table('tasks')->insert([
        'subject' => 'Test Task for Editing',
        'description' => 'This is a test task to check start date editing',
        'status' => 'not_started',
        'start_date' => null, // No start date initially
        'due_date' => '2026-03-15',
        'priority' => 'medium',
        'related' => 'project',
        'type' => 'task',
        'is_billed' => 0,
        'created_by' => 2, // admin user
        'created_at' => now(),
        'updated_at' => now()
    ]);
    
    DB::statement('PRAGMA foreign_keys = ON');
    
    echo "Test task created successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}