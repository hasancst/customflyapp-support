<?php

namespace App\Modul\SEO\Services;

class SEOAnalyzer
{
    public function analisis($data)
    {
        $skor = 100;
        $rekomendasi = [];

        // 1. Cek Panjang Judul
        $judulLen = strlen($data['judul'] ?? '');
        if ($judulLen < 40) {
            $skor -= 10;
            $rekomendasi[] = "Judul terlalu pendek. Gunakan 50-60 karakter untuk hasil optimal.";
        } elseif ($judulLen > 70) {
            $skor -= 5;
            $rekomendasi[] = "Judul terlalu panjang. Potensi terpotong di hasil cari Google.";
        }

        // 2. Cek Konten
        $konten = strip_tags($data['isi'] ?? '');
        $wordCount = str_word_count($konten);
        if ($wordCount < 300) {
            $skor -= 15;
            $rekomendasi[] = "Konten terlalu singkat ($wordCount kata). Minimal 300 kata untuk SEO yang baik.";
        }

        // 3. Cek Tag Heading (H2/H3)
        if (!preg_match('/<h[2-3]/i', $data['isi'] ?? '')) {
            $skor -= 10;
            $rekomendasi[] = "Gunakan Subheading (H2 atau H3) untuk mempermudah pembaca dan mesin pencari.";
        }

        // 4. Cek Media (Gambar)
        if (!preg_match('/<img/i', $data['isi'] ?? '') && empty($data['gambar_utama'])) {
            $skor -= 10;
            $rekomendasi[] = "Konten tanpa gambar kurang menarik. Tambahkan setidaknya satu gambar.";
        }

        // 5. Slug / URL
        if (isset($data['judul'])) {
            $slug = \Illuminate\Support\Str::slug($data['judul']);
            if (strlen($slug) > 100) {
                $skor -= 5;
                $rekomendasi[] = "URL berita berpotensi terlalu panjang.";
            }
        }

        // 6. Ringkasan / Meta Description
        $ringkasanLen = strlen($data['ringkasan'] ?? '');
        if ($ringkasanLen < 120) {
            $skor -= 10;
            $rekomendasi[] = "Ringkasan (Meta Description) terlalu pendek. Idealnya 120-160 karakter.";
        } elseif ($ringkasanLen > 170) {
            $skor -= 5;
            $rekomendasi[] = "Ringkasan terlalu panjang. Akan terpotong di Google.";
        }

        return [
            'skor' => max(0, $skor),
            'rekomendasi' => $rekomendasi,
            'status' => $this->getStatus($skor)
        ];
    }

    private function getStatus($skor)
    {
        if ($skor >= 80) return 'Bagus';
        if ($skor >= 50) return 'Cukup';
        return 'Kurang';
    }
}
