<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check task data
$task = DB::table('tasks')->find(2);
echo "Task ID 2 data:\n";
echo "start_date: " . ($task->start_date ?? 'NULL') . "\n";
echo "due_date: " . ($task->due_date ?? 'NULL') . "\n";
echo "date: " . ($task->date ?? 'NULL') . "\n";

// Check all columns
$columns = array_keys((array)$task);
echo "\nAll columns: " . implode(', ', $columns) . "\n";