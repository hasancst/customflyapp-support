<?php

namespace App\Inti;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class ThemeManager
{
    /**
     * Mendapatkan tema yang aktif saat ini.
     */
    public function getTemaAktif()
    {
        try {
            $tema = DB::table('tema')->where('aktif', true)->first();
            return $tema ? $tema->slug : 'default';
        } catch (\Exception $e) {
            return 'default';
        }
    }

    /**
     * Mengaktifkan tema tertentu.
     */
    public function setTema($slug)
    {
        DB::table('tema')->update(['aktif' => false]);
        DB::table('tema')->where('slug', $slug)->update(['aktif' => true]);
        
        // Bersihkan cache view
        app('view.finder')->flush();
    }

    /**
     * Mendaftarkan lokasi view tema ke Laravel.
     */
    public function registrasiLokasiView()
    {
        $temaAktif = $this->getTemaAktif();
        $pathTema = resource_path("theme/{$temaAktif}");

        if (File::exists($pathTema)) {
            // Urutan: Cek di tema dulu, baru default views
            View::prependNamespace('tema', $pathTema);
            
            // Tambahkan ke main search path agar bisa override views bawaan
            app('view.finder')->prependLocation($pathTema);
        } else {
            // Fallback: Register the first available theme or a generic path to avoid 500
            $fallback = resource_path('views');
            View::prependNamespace('tema', $fallback);
        }
    }
}
