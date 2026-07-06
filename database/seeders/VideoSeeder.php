<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'judul' => 'Mengenal Keamanan Siber di Era Digital',
                'url' => 'https://www.youtube.com/watch?v=66zTAsL69pQ',
                'keterangan' => 'Video edukasi mengenai pentingnya menjaga data pribadi dan keamanan perangkat di dunia maya.',
                'aktif' => true,
                'unggulan' => true,
            ],
            [
                'judul' => 'Aspek Hukum Transaksi Elektronik',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'keterangan' => 'Memahami UU ITE dan bagaimana hukum melindungi konsumen dalam transaksi online.',
                'aktif' => true,
                'unggulan' => false,
            ],
        ];

        foreach ($videos as $video) {
            \DB::table('video')->updateOrInsert(
                ['url' => $video['url']],
                array_merge($video, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
