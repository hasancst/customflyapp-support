<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Header Menus
        $headerMenus = [
            ['label' => 'Beranda', 'url' => '/', 'target' => '_self', 'urutan' => 1, 'posisi' => 'header'],
            ['label' => 'Berita', 'url' => '/berita', 'target' => '_self', 'urutan' => 2, 'posisi' => 'header'],
            ['label' => 'Artikel', 'url' => '/artikel', 'target' => '_self', 'urutan' => 3, 'posisi' => 'header'],
            ['label' => 'Video', 'url' => '/video', 'target' => '_self', 'urutan' => 4, 'posisi' => 'header'],
            ['label' => 'Kontak', 'url' => '/kontak', 'target' => '_self', 'urutan' => 5, 'posisi' => 'header'],
        ];

        // Footer Menus
        $footerMenus = [
            ['label' => 'Tentang Kami', 'url' => '/tentang', 'target' => '_self', 'urutan' => 1, 'posisi' => 'footer'],
            ['label' => 'Redaksi', 'url' => '/redaksi', 'target' => '_self', 'urutan' => 2, 'posisi' => 'footer'],
            ['label' => 'Kebijakan Privasi', 'url' => '/kebijakan', 'target' => '_self', 'urutan' => 3, 'posisi' => 'footer'],
            ['label' => 'Syarat & Ketentuan', 'url' => '/syarat', 'target' => '_self', 'urutan' => 4, 'posisi' => 'footer'],
            ['label' => 'Kontak', 'url' => '/kontak', 'target' => '_self', 'urutan' => 5, 'posisi' => 'footer'],
        ];

        foreach (array_merge($headerMenus, $footerMenus) as $menu) {
            \DB::table('menus')->updateOrInsert(
                ['label' => $menu['label'], 'posisi' => $menu['posisi']],
                array_merge($menu, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
