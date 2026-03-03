<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class DeleteOldLogs extends Command
{
    protected $signature = 'logs:cleanup';
    protected $description = 'Delete Logs that are older than one month';

    public function handle()
    {
        $cutoff = Carbon::now()->subMonth();
        $deletedCount = 0;
        $totalProcessed = 0;
    
        // Define log directories to process
        $logDirectories = [
            'requests' => storage_path('logs/requests'),
            'errors' => storage_path('logs/errors')
        ];
    
        foreach ($logDirectories as $type => $logDir) {
            $this->info("Processing {$type} logs...");
            
            if (!File::exists($logDir)) {
                $this->warn("{$type} logs directory not found: {$logDir}");
                continue;
            }
        
            $files = File::files($logDir);
            
            if (empty($files)) {
                $this->info("No {$type} log files found.");
                continue;
            }
        
            $dirDeletedCount = 0;
            $dirTotalFiles = count($files);
            $totalProcessed += $dirTotalFiles;
        
            foreach ($files as $file) {
                $lastModified = File::lastModified($file->getPathname());
                $fileDate = Carbon::createFromTimestamp($lastModified);
                
                if ($lastModified < $cutoff->timestamp) {
                    try {
                        File::delete($file->getPathname());
                        $deletedCount++;
                        $dirDeletedCount++;
                        $this->info("Deleted {$type}: {$file->getFilename()} (modified: {$fileDate->format('Y-m-d H:i:s')})");
                    } catch (\Exception $e) {
                        $this->error("Failed to delete {$file->getFilename()}: {$e->getMessage()}");
                    }
                } else {
                    $this->line("Skipped {$type}: {$file->getFilename()} (modified: {$fileDate->format('Y-m-d H:i:s')})");
                }
            }
        
            $this->info("{$type}: Deleted {$dirDeletedCount} out of {$dirTotalFiles} files.");
        }
    
        $this->info("Successfully deleted {$deletedCount} out of {$totalProcessed} total log files older than 30 days.");
        return 0;
    }

}
