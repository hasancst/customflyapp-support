<?php

namespace App\Inti;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Pure-PHP database backup/restore for MySQL.
 * Does not call exec(), shell_exec(), or any other shell function —
 * safe on servers where those are disabled in php.ini.
 */
class DatabaseBackup
{
    public static function execute(): array
    {
        $backupDir = storage_path('app/backups');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $filename = 'backup-' . date('Y-m-d-His') . '.sql';
        $path     = $backupDir . '/' . $filename;

        try {
            $sql = self::dumpMysql();
            file_put_contents($path, $sql);

            return [
                'success' => true,
                'file'    => $filename,
                'path'    => $path,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Restore database from a previously created .sql backup file.
     */
    public static function restore(string $backupPath): array
    {
        if (!File::exists($backupPath)) {
            return [
                'success' => false,
                'error'   => 'Backup file not found.',
            ];
        }

        try {
            $sql = file_get_contents($backupPath);
            if ($sql === false) {
                throw new \RuntimeException('Cannot read backup file.');
            }

            self::importMysql($sql);

            return ['success' => true, 'message' => 'Database restored successfully.'];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Dump all tables in the default MySQL connection to a SQL string.
     */
    private static function dumpMysql(): string
    {
        $pdo    = DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();

        $lines   = [];
        $lines[] = '-- Backup dibuat: ' . date('Y-m-d H:i:s');
        $lines[] = '-- Database: ' . $dbName;
        $lines[] = '';
        $lines[] = 'SET FOREIGN_KEY_CHECKS=0;';
        $lines[] = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";';
        $lines[] = 'SET NAMES utf8mb4;';
        $lines[] = '';

        // Fetch table list
        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $quotedTable = self::quoteIdentifier($table);

            // ── DROP + CREATE ───────────────────────────────────────────────
            $lines[] = "-- --------------------------------------------------------";
            $lines[] = "-- Tabel: `{$table}`";
            $lines[] = "-- --------------------------------------------------------";
            $lines[] = '';
            $lines[] = "DROP TABLE IF EXISTS {$quotedTable};";

            $createRow = $pdo->query("SHOW CREATE TABLE {$quotedTable}")->fetch(\PDO::FETCH_NUM);
            $lines[] = $createRow[1] . ';';
            $lines[] = '';

            // ── Data rows ───────────────────────────────────────────────────
            $rowStmt = $pdo->query("SELECT * FROM {$quotedTable}");
            $rows    = $rowStmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($rows) === 0) {
                continue;
            }

            // Build column list once
            $columns      = array_keys($rows[0]);
            $columnList   = implode(', ', array_map([self::class, 'quoteIdentifier'], $columns));

            // Batch inserts in groups of 500 for reasonable file sizes
            foreach (array_chunk($rows, 500) as $chunk) {
                $valueSets = [];
                foreach ($chunk as $row) {
                    $vals = array_map(function ($val) use ($pdo) {
                        return $val === null ? 'NULL' : $pdo->quote((string) $val);
                    }, array_values($row));
                    $valueSets[] = '(' . implode(', ', $vals) . ')';
                }

                $lines[] = "INSERT INTO {$quotedTable} ({$columnList}) VALUES";
                $lines[] = implode(",\n", $valueSets) . ';';
                $lines[] = '';
            }
        }

        $lines[] = '';
        $lines[] = 'SET FOREIGN_KEY_CHECKS=1;';

        return implode("\n", $lines);
    }

    /**
     * Execute a multi-statement SQL dump inside a transaction.
     * Splits on statement boundaries that are not inside quoted strings.
     */
    private static function importMysql(string $sql): void
    {
        // Strip comments and split into individual statements
        $statements = self::splitSqlStatements($sql);

        DB::unprepared('SET FOREIGN_KEY_CHECKS=0');
        try {
            DB::transaction(function () use ($statements) {
                foreach ($statements as $stmt) {
                    $stmt = trim($stmt);
                    if ($stmt !== '') {
                        DB::unprepared($stmt);
                    }
                }
            });
        } finally {
            DB::unprepared('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * Minimal SQL splitter: handles semicolons inside single-quoted strings
     * and line/block comments.  Not a full parser, but handles mysqldump/our
     * own dump output correctly.
     */
    private static function splitSqlStatements(string $sql): array
    {
        $statements = [];
        $current    = '';
        $len        = strlen($sql);
        $i          = 0;
        $inString   = false;
        $stringChar = '';

        while ($i < $len) {
            $ch = $sql[$i];

            // Handle escaped chars inside strings
            if ($inString) {
                if ($ch === '\\') {
                    $current .= $ch . ($sql[$i + 1] ?? '');
                    $i += 2;
                    continue;
                }
                if ($ch === $stringChar) {
                    $inString = false;
                }
                $current .= $ch;
                $i++;
                continue;
            }

            // Start of string literal
            if ($ch === '\'' || $ch === '"' || $ch === '`') {
                $inString   = true;
                $stringChar = $ch;
                $current   .= $ch;
                $i++;
                continue;
            }

            // Line comment
            if ($ch === '-' && ($sql[$i + 1] ?? '') === '-') {
                $end = strpos($sql, "\n", $i);
                $i   = $end === false ? $len : $end + 1;
                continue;
            }

            // Block comment
            if ($ch === '/' && ($sql[$i + 1] ?? '') === '*') {
                $end = strpos($sql, '*/', $i + 2);
                $i   = $end === false ? $len : $end + 2;
                continue;
            }

            // Statement terminator
            if ($ch === ';') {
                $statements[] = $current;
                $current      = '';
                $i++;
                continue;
            }

            $current .= $ch;
            $i++;
        }

        if (trim($current) !== '') {
            $statements[] = $current;
        }

        return $statements;
    }

    /**
     * Wrap an identifier in back-ticks, escaping any back-ticks within it.
     */
    private static function quoteIdentifier(string $name): string
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }
}
