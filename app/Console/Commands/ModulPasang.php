<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class ModulPasang extends Command
{
    protected $signature = 'modul:pasang {slug}';
    protected $description = 'Memasang modul baru (Migrate + Aktifkan)';

    public function handle()
    {
        $slug = $this->argument('slug');
        $pathModul = app_path("Modul/{$slug}");

        if (!File::exists($pathModul)) {
            $this->error("Modul [{$slug}] tidak ditemukan di app/Modul.");
            return;
        }

        $manifestPath = $pathModul . "/manifest.json";
        if (!File::exists($manifestPath)) {
            $this->error("Manifest tidak ditemukan untuk modul [{$slug}].");
            return;
        }

        $manifest = json_decode(File::get($manifestPath), true);
        $nama = $manifest['nama'] ?? $slug;
        $versi = $manifest['versi'] ?? '1.0.0';
        $deskripsi = $manifest['deskripsi'] ?? '';

        $this->info("Sedang memasang modul: {$nama}...");

        // Jalankan Migrasi Modul
        $pathMigrasi = "app/Modul/{$slug}/Database/Migrasi";
        if (File::exists(base_path($pathMigrasi))) {
            Artisan::call('migrate', [
                '--path' => $pathMigrasi,
                '--force' => true
            ]);
            $this->info("Migrasi modul berhasil dijalankan.");
        }

        // Simpan ke Database
        DB::table('modul')->updateOrInsert(
            ['slug' => $slug],
            [
                'nama' => $nama,
                'versi' => $versi,
                'deskripsi' => $deskripsi,
                'aktif' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $this->info("Modul [{$nama}] berhasil dipasang dan diaktifkan.");
    }
}
