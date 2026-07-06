<?php

namespace App\Inti;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaManager
{
    protected $webpAktif;
    protected $kualitas;

    public function __construct()
    {
        $settings = DB::table('pengaturan')->where('kunci', 'like', 'optimasi_webp_%')->pluck('nilai', 'kunci');
        $this->webpAktif = ($settings['optimasi_webp_aktif'] ?? '0') == '1';
        $this->kualitas = (int) ($settings['optimasi_webp_kualitas'] ?? '80');
    }

    /**
     * Upload dan proses gambar.
     */
    public function upload($file, $folder = 'uploads')
    {
        $namaAsli = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ekstensi = $file->getClientOriginalExtension();
        $filename = time() . '_' . str($namaAsli)->slug() . '.' . $ekstensi;

        if ($this->webpAktif && in_array(strtolower($ekstensi), ['jpg', 'jpeg', 'png', 'gif'])) {
            return $this->convertToWebp($file, $folder, $namaAsli);
        }

        return $file->storeAs($folder, $filename, 'public');
    }

    /**
     * Konversi ke WebP.
     */
    protected function convertToWebp($file, $folder, $namaAsli)
    {
        $filename = time() . '_' . str($namaAsli)->slug() . '.webp';
        $path = storage_path('app/public/' . $folder . '/' . $filename);

        // Pastikan direktori ada
        if (!file_exists(storage_path('app/public/' . $folder))) {
            mkdir(storage_path('app/public/' . $folder), 0755, true);
        }

        // Gunakan GD atau Imagick via Native PHP jika Intervention belum di-install
        // Namun karena user minta "terbukti berjalan", saya akan gunakan fungsi built-in PHP GD
        $image = null;
        $info = @getimagesize($file->getRealPath());
        
        if (!$info || !isset($info['mime'])) {
             return $file->storeAs($folder, time() . '_' . str($namaAsli)->slug() . '.' . $file->getClientOriginalExtension(), 'public');
        }

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($file->getRealPath());
        elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($file->getRealPath());
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }
        elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($file->getRealPath());
            imagepalettetotruecolor($image);
        }

        if ($image) {
            imagewebp($image, $path, $this->kualitas);
            imagedestroy($image);
            return $folder . '/' . $filename;
        }

        // Fallback jika gagal
        return $file->storeAs($folder, time() . '_' . str($namaAsli)->slug() . '.' . $file->getClientOriginalExtension(), 'public');
    }
}
