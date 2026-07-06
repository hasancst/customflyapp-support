<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = \DB::table('pengguna')->first();
        $authorId = $author ? $author->id : 1;

        $categories = [
            ['nama' => 'Teknologi', 'slug' => 'teknologi'],
            ['nama' => 'Hukum', 'slug' => 'hukum'],
            ['nama' => 'Cyber Security', 'slug' => 'cyber-security'],
            ['nama' => 'Edukasi', 'slug' => 'edukasi'],
        ];

        foreach ($categories as $cat) {
            \DB::table('kategori_berita')->updateOrInsert(
                ['slug' => $cat['slug']],
                array_merge($cat, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $news = [
            [
                'judul' => 'Tren Keamanan Siber 2026: Ancaman AI Generatif',
                'slug' => 'tren-keamanan-siber-2026-ancaman-ai-generatif',
                'ringkasan' => 'Perkembangan AI generatif membawa tantangan baru dalam dunia keamanan siber.',
                'isi' => '<p>Perkembangan AI generatif membawa tantangan baru dalam dunia keamanan siber. Serangan phishing kini menjadi lebih canggih dan sulit dideteksi...</p>',
                'kategori' => 'Cyber Security',
                'unggulan' => true,
                'penulis_id' => $authorId,
                'gambar_utama' => 'berita/sampul/teknologi.png',
            ],
            [
                'judul' => 'Memahami Hak Kekayaan Intelektual bagi Kreator Digital',
                'slug' => 'memahami-hak-kekayaan-intelektual-bagi-kreator-digital',
                'ringkasan' => 'Di era digital, perlindungan karya menjadi sangat krusial.',
                'isi' => '<p>Di era digital, perlindungan karya menjadi sangat krusial. Kreator perlu memahami prosedur pendaftaran HAKI untuk melindungi aset mereka...</p>',
                'kategori' => 'Hukum',
                'unggulan' => false,
                'penulis_id' => $authorId,
                'gambar_utama' => 'berita/sampul/hukum.png',
            ],
        ];

        foreach ($news as $item) {
            $kategoriInput = $item['kategori'];
            unset($item['kategori']);

            $beritaId = \DB::table('berita')->updateOrInsert(
                ['slug' => $item['slug']],
                array_merge($item, [
                    'kategori' => $kategoriInput,
                    'created_at' => now(), 
                    'updated_at' => now()
                ])
            );

            // Fetch ID if it updatedOrInsert didn't return it
            $berita = \DB::table('berita')->where('slug', $item['slug'])->first();
            $cat = \DB::table('kategori_berita')->where('nama', $kategoriInput)->first();

            if ($berita && $cat) {
                \DB::table('berita_memiliki_kategori')->updateOrInsert(
                    ['berita_id' => $berita->id, 'kategori_id' => $cat->id]
                );
            }
        }
    }
}
