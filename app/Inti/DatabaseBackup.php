<?php

namespace App\Inti;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DatabaseBackup
{
    public static function execute()
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $filename = 'backup-' . date('Y-m-d-His') . '.sql';
        $path = $backupDir . '/' . $filename;

        // Path pg_dump (khusus server ini)
        $pgDumpPath = '/www/server/pgsql/bin/pg_dump';
        
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '5432');
        $dbName = env('DB_DATABASE', 'rc');
        $dbUser = env('DB_USERNAME', 'rc');
        $dbPass = env('DB_PASSWORD', '');

        // PostgreSQL menggunakan PGPASSWORD env variable untuk password
        $command = "PGPASSWORD='{$dbPass}' {$pgDumpPath} -h {$dbHost} -p {$dbPort} -U {$dbUser} {$dbName} > {$path}";

        \exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            return [
                'success' => true,
                'file' => $filename,
                'path' => $path
            ];
        }

        return [
            'success' => false,
            'error' => 'Error code: ' . $returnVar
        ];
    }

    /**
     * Restore database from backup file
     */
    public static function restore($backupPath)
    {
        if (!File::exists($backupPath)) {
            return [
                'success' => false,
                'error' => 'Backup file not found'
            ];
        }

        // Path pg_restore (khusus server ini)
        $pgRestorePath = '/www/server/pgsql/bin/psql';
        
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '5432');
        $dbName = env('DB_DATABASE', 'rc');
        $dbUser = env('DB_USERNAME', 'rc');
        $dbPass = env('DB_PASSWORD', '');

        // PostgreSQL restore menggunakan psql
        $command = "PGPASSWORD='{$dbPass}' {$pgRestorePath} -h {$dbHost} -p {$dbPort} -U {$dbUser} {$dbName} < {$backupPath} 2>&1";

        \exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            return [
                'success' => true,
                'message' => 'Database restored successfully'
            ];
        }

        return [
            'success' => false,
            'error' => 'Error code: ' . $returnVar,
            'output' => implode("\n", $output)
        ];
    }
}
