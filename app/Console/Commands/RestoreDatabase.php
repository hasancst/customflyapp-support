<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:restore-database {file?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore database from backup file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backupDir = storage_path('app/backups');
        
        if (!File::exists($backupDir)) {
            $this->error('Backup directory does not exist.');
            return 1;
        }

        $filename = $this->argument('file');
        
        // If no file specified, show list and ask user to choose
        if (!$filename) {
            $files = File::files($backupDir);
            
            if (empty($files)) {
                $this->error('No backup files found.');
                return 1;
            }
            
            $this->info('Available backup files:');
            $choices = [];
            foreach ($files as $index => $file) {
                $basename = basename($file);
                $size = File::size($file);
                $date = date('Y-m-d H:i:s', File::lastModified($file));
                $this->line(($index + 1) . ". {$basename} ({$this->formatBytes($size)}) - {$date}");
                $choices[] = $basename;
            }
            
            $filename = $this->choice('Select backup file to restore', $choices);
        }
        
        $path = $backupDir . '/' . $filename;
        
        if (!File::exists($path)) {
            $this->error("Backup file not found: {$filename}");
            return 1;
        }

        if (!$this->confirm('This will restore the database from backup. Continue?', false)) {
            $this->info('Restore cancelled.');
            return 0;
        }

        $this->info('Restoring database from: ' . $filename);
        $result = \App\Inti\DatabaseBackup::restore($path);
        
        if ($result['success']) {
            $this->info('Database restored successfully!');
            return 0;
        } else {
            $this->error('Restore failed: ' . ($result['error'] ?? 'Unknown error'));
            return 1;
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
