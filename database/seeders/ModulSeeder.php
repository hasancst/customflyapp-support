<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            ['nama' => 'Manajemen Berita', 'slug' => 'berita', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola berita portal.', 'aktif' => true],
            ['nama' => 'Manajemen Artikel', 'slug' => 'artikel', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola artikel dan halaman statis.', 'aktif' => true],
            ['nama' => 'Video', 'slug' => 'video', 'versi' => '1.0.0', 'deskripsi' => 'Modul pengelolaan video Youtube.', 'aktif' => true],
            ['nama' => 'Manajemen Menu', 'slug' => 'menu', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola navigasi menu pada website.', 'aktif' => true],
            ['nama' => 'Manajemen Pengguna', 'slug' => 'pengguna', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola hak akses dan pengguna.', 'aktif' => true],
            ['nama' => 'Statistik', 'slug' => 'statistik', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mencatat statistik pengunjung.', 'aktif' => true],
            ['nama' => 'Komentar', 'slug' => 'komentar', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola komentar.', 'aktif' => true],
            ['nama' => 'Iklan', 'slug' => 'iklan', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola iklan.', 'aktif' => true],
            ['nama' => 'Kontak', 'slug' => 'kontak', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk mengelola pesan kontak.', 'aktif' => true],
            ['nama' => 'SEO', 'slug' => 'seo', 'versi' => '1.0.0', 'deskripsi' => 'Modul untuk optimasi SEO.', 'aktif' => true],
        ];

        foreach ($modules as $mod) {
            \DB::table('modul')->updateOrInsert(
                ['slug' => $mod['slug']],
                array_merge($mod, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
