<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = \DB::table('pengguna')->first();
        $authorId = $author ? $author->id : 1;

        $pages = [
            [
                'judul' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'isi' => '
<div class="static-page-content" style="padding: 40px 0;">
    <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; color: #334155; font-size: 1.1rem;">
        <p style="margin-bottom: 25px;">
            Selamat datang di <strong>Rumah Koalisi</strong>, platform informasi dan edukasi terpercaya yang berdedikasi untuk memberikan pemahaman mendalam mengenai perkembangan teknologi, keamanan siber, dan aspek hukum digital di Indonesia.
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin: 50px 0;">
            <div style="background: #f8fafc; padding: 30px; border-radius: 20px; border-left: 5px solid var(--primary);">
                <h3 style="color: #0f172a; margin-bottom: 15px; font-weight: 800;">Visi Kami</h3>
                <p>Menjadi pusat referensi digital utama yang mencerdaskan bangsa melalui konten berkualitas, akurat, dan mudah dipahami.</p>
            </div>
            <div style="background: #f8fafc; padding: 30px; border-radius: 20px; border-left: 5px solid var(--accent);">
                <h3 style="color: #0f172a; margin-bottom: 15px; font-weight: 800;">Misi Kami</h3>
                <p>Menyediakan berita terkini, panduan praktis, dan analisis mendalam untuk membantu masyarakat tetap aman dan produktif di dunia maya.</p>
            </div>
        </div>

        <p style="margin-bottom: 25px;">
            Kami percaya bahwa informasi adalah kekuatan. Di tengah derasnya arus digital, kami hadir sebagai filter untuk menyajikan fakta dan edukasi yang relevan bagi profesional, pelajar, maupun pengguna internet umum.
        </p>
    </div>
</div>',
                'status' => 'publikasi',
                'penulis_id' => $authorId,
            ],
            [
                'judul' => 'Redaksi',
                'slug' => 'redaksi',
                'isi' => '
<div class="static-page-content" style="padding: 40px 0;">
    <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; color: #334155; font-size: 1.1rem;">
        <p style="margin-bottom: 30px;">
            Tim Redaksi <strong>Rumah Koalisi</strong> terdiri dari para jurnalis, analis keamanan siber, dan pakar hukum yang memiliki integritas tinggi dan komitmen untuk menyajikan informasi yang objektif.
        </p>

        <div style="margin-bottom: 40px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px;">
            <h3 style="color: #0f172a; margin-bottom: 10px; font-weight: 800;">Manajemen</h3>
            <p><strong>Pimpinan Umum:</strong> Hasanudin</p>
            <p><strong>Pimpinan Redaksi:</strong> Ahmad Fauzi</p>
        </div>

        <div style="margin-bottom: 40px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px;">
            <h3 style="color: #0f172a; margin-bottom: 10px; font-weight: 800;">Tim Penulis</h3>
            <p><strong>Editor Teknologi:</strong> Rahmat Hidayat</p>
            <p><strong>Analis Keamanan:</strong> Siti Aminah</p>
            <p><strong>Kontributor Hukum:</strong> Dr. Budi Santoso, S.H., M.H.</p>
        </div>

        <div style="background: #f1f5f9; padding: 25px; border-radius: 15px;">
            <p style="font-style: italic; font-size: 0.95rem;">
                Seluruh wartawan/penulis kami dibekali dengan kartu identitas resmi dan dilarang menerima imbalan dalam bentuk apa pun dalam menjalankan tugas jurnalistik.
            </p>
        </div>
    </div>
</div>',
                'status' => 'publikasi',
                'penulis_id' => $authorId,
            ],
            [
                'judul' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'isi' => '
<div class="static-page-content" style="padding: 40px 0;">
    <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; color: #334155;">
        <p style="margin-bottom: 20px;">Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda.</p>
        <h3 style="margin: 30px 0 15px; color: #0f172a; font-weight: 700;">1. Pengumpulan Informasi</h3>
        <p>Kami hanya mengumpulkan data yang Anda berikan secara sukarela melalui formulir kontak atau pendaftaran newsletter.</p>
        <h3 style="margin: 30px 0 15px; color: #0f172a; font-weight: 700;">2. Keamanan Data</h3>
        <p>Kami menerapkan standar keamanan terbaik untuk melindungi data pribadi Anda dari akses tidak sah.</p>
    </div>
</div>',
                'status' => 'publikasi',
                'penulis_id' => $authorId,
            ],
            [
                'judul' => 'Syarat & Ketentuan',
                'slug' => 'syarat-ketentuan',
                'isi' => '
<div class="static-page-content" style="padding: 40px 0;">
    <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; color: #334155;">
        <p style="margin-bottom: 20px;">Dengan mengakses situs ini, Anda menyetujui syarat-syarat penggunaan sebagaimana tercantum di bawah ini.</p>
        <h3 style="margin: 30px 0 15px; color: #0f172a; font-weight: 700;">Hak Kekayaan Intelektual</h3>
        <p>Seluruh materi di situs ini adalah milik Rumah Koalisi dan dilindungi oleh undang-undang hak cipta.</p>
    </div>
</div>',
                'status' => 'publikasi',
                'penulis_id' => $authorId,
            ],
        ];

        foreach ($pages as $page) {
            \DB::table('artikel')->updateOrInsert(
                ['slug' => $page['slug']],
                array_merge($page, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
