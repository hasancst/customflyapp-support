<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $aktif = \Illuminate\Support\Facades\DB::table('pengaturan')->where('kunci', 'backup_otomatis')->value('nilai');
        
        if ($aktif == '1') {
            $this->info('Memulai backup database otomatis...');
            $result = \App\Inti\DatabaseBackup::execute();
            
            if ($result['success']) {
                $this->info('Backup berhasil: ' . $result['file']);
            } else {
                $this->error('Backup gagal: ' . ($result['error'] ?? 'Unknown error'));
            }
        } else {
            $this->info('Backup otomatis dinonaktifkan di pengaturan.');
        }
    }
}
