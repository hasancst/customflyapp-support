<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Clear existing menus
        DB::table('menus')->truncate();

        // 1. Beranda
        DB::table('menus')->insert([
            'label' => 'Beranda',
            'url' => '/',
            'urutan' => 1,
            'parent_id' => null,
            'posisi' => 'header',
            'target' => '_self',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Berita (Parent)
        $beritaId = DB::table('menus')->insertGetId([
            'label' => 'Berita',
            'url' => '#',
            'urutan' => 2,
            'parent_id' => null,
            'posisi' => 'header',
            'target' => '_self',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Submenu Berita
        DB::table('menus')->insert([
            ['label' => 'Nasional', 'url' => '/kategori-berita/nasional', 'urutan' => 1, 'parent_id' => $beritaId, 'posisi' => 'header', 'target' => '_self', 'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Internasional', 'url' => '/kategori-berita/internasional', 'urutan' => 2, 'parent_id' => $beritaId, 'posisi' => 'header', 'target' => '_self', 'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Hukum', 'url' => '/kategori-berita/hukum', 'urutan' => 3, 'parent_id' => $beritaId, 'posisi' => 'header', 'target' => '_self', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Artikel
        DB::table('menus')->insert([
            'label' => 'Artikel',
            'url' => '/artikel',
            'urutan' => 3,
            'parent_id' => null,
            'posisi' => 'header',
            'target' => '_self',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 4. Video (Since we added this module)
        DB::table('menus')->insert([
            'label' => 'Video',
            'url' => '/video', // We might not have a public route for this yet, but let's add it for now or link to homepage section
            'urutan' => 4,
            'parent_id' => null,
            'posisi' => 'header',
            'target' => '_self',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 5. Tentang Kami
        DB::table('menus')->insert([
            'label' => 'Tentang Kami',
            'url' => '/tentang-kami',
            'urutan' => 5,
            'parent_id' => null,
            'posisi' => 'header',
            'target' => '_self',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // 6. Kontak
        DB::table('menus')->insert([
            'label' => 'Kontak',
            'url' => '/kontak',
            'urutan' => 6,
            'parent_id' => null,
            'posisi' => 'header',
            'target' => '_self',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        DB::table('menus')->truncate();
    }
};
