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
            $slug = $tema ? $tema->slug : 'imakecustom';
            
            // Jika tema aktif tidak memiliki index.blade.php, otomatis gunakan fallback 'imakecustom'
            if (!File::exists(resource_path("theme/{$slug}/index.blade.php"))) {
                return 'imakecustom';
            }
            return $slug;
        } catch (\Exception $e) {
            return 'imakecustom';
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
        $fallback = resource_path('theme/imakecustom');

        $paths = [];
        if (File::exists($pathTema)) {
            $paths[] = $pathTema;
            app('view.finder')->prependLocation($pathTema);
        }
        if (File::exists($fallback) && $pathTema !== $fallback) {
            $paths[] = $fallback;
        }
        if (empty($paths)) {
            $paths[] = resource_path('views');
        }

        View::replaceNamespace('tema', array_values(array_unique($paths)));
    }
}
