<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class ModulCopot extends Command
{
    protected $signature = 'modul:copot {slug}';
    protected $description = 'Mencopot modul (Rollback + Hapus Status)';

    public function handle()
    {
        $slug = $this->argument('slug');

        $modul = DB::table('modul')->where('slug', $slug)->first();
        if (!$modul) {
            $this->error("Modul [{$slug}] tidak ditemukan di database.");
            return;
        }

        $this->warn("Sedang mencopot modul: {$modul->nama}...");

        // Rollback Migrasi Modul
        $pathMigrasi = "app/Modul/{$slug}/Database/Migrasi";
        if (File::exists(base_path($pathMigrasi))) {
            Artisan::call('migrate:rollback', [
                '--path' => $pathMigrasi,
                '--force' => true
            ]);
            $this->info("Rollback migrasi modul berhasil.");
        }

        // Hapus dari Database
        DB::table('modul')->where('slug', $slug)->delete();

        $this->info("Modul [{$slug}] berhasil dicopot sepenuhnya.");
    }
}
