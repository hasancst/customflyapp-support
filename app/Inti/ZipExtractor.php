<?php

namespace App\Inti;

use ZipArchive;
use Illuminate\Support\Facades\File;
use Exception;

class ZipExtractor
{
    /**
     * Ekstrak ZIP ke tujuan tertentu.
     */
    public function ekstrak($zipPath, $tujuan)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            if (!File::exists($tujuan)) {
                File::makeDirectory($tujuan, 0755, true);
            }
            
            $zip->extractTo($tujuan);
            $zip->close();
            return true;
        } else {
            throw new Exception("Gagal membuka file ZIP.");
        }
    }

    /**
     * Validasi struktur ZIP modul.
     */
    public function validasiModul($zipPath)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            $hasManifest = false;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (basename($filename) === 'manifest.json') {
                    $hasManifest = true;
                    break;
                }
            }
            $zip->close();
            return $hasManifest;
        }
        return false;
    }
}
