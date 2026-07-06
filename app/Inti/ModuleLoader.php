<?php

namespace App\Inti;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModuleLoader
{
    /**
     * Memuat semua modul yang aktif.
     */
    public function muatSemua()
    {
        try {
            if (!Schema::hasTable('modul')) {
                return;
            }
        } catch (\Exception $e) {
            // Database belum siap atau driver hilang, abaikan muat modul
            return;
        }

        $folderModul = app_path('Modul');
        if (!File::exists($folderModul)) {
            return;
        }

        $daftarModul = File::directories($folderModul);
        $modulAktif = DB::table('modul')->where('aktif', true)->pluck('slug')->toArray();

        foreach ($daftarModul as $path) {
            $slug = basename($path);
            
            // Cek case-insensitive (misal folder 'Iklan', db 'iklan')
            if (in_array(strtolower($slug), $modulAktif) || in_array($slug, $modulAktif)) {
                $this->registrasiModul($path, $slug);
            }
        }
    }

    /**
     * Meregistrasi ServiceProvider milik modul.
     */
    protected function registrasiModul($path, $slug)
    {
        $manifestPath = $path . '/manifest.json';
        if (!File::exists($manifestPath)) {
            return;
        }

        $manifest = json_decode(File::get($manifestPath), true);
        $namaClassProvider = "App\\Modul\\{$slug}\\{$slug}ServiceProvider";

        if (class_exists($namaClassProvider)) {
            app()->register($namaClassProvider);
        }
    }
}
