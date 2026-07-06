<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $penulisId = 1; // Admin Rumah Koalisi

        // Define categories we need
        $categories = [
            'nasional' => 'Nasional',
            'internasional' => 'Internasional',
            'hukum' => 'Hukum'
        ];

        $categoryIds = [];

        // Ensure categories exist and get their IDs
        foreach ($categories as $slug => $name) {
            $cat = DB::table('kategori_berita')->where('slug', $slug)->first();
            if (!$cat) {
                $id = DB::table('kategori_berita')->insertGetId([
                    'nama' => $name,
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $categoryIds[$slug] = $id;
            } else {
                $categoryIds[$slug] = $cat->id;
            }
        }

        $news = [
            // Kategori Nasional
            [
                'judul' => 'DPR RI Bahas RUU Perlindungan Data Pribadi Tahap Akhir',
                'ringkasan' => 'Sidang paripurna hari ini mengagendakan pembahasan akhir mengenai regulasi perlindungan data warga di ranah digital.',
                'isi' => '<p>Jakarta - Dewan Perwakilan Rakyat (DPR) RI hari ini mempercepat pembahasan Rancangan Undang-Undang Perlindungan Data Pribadi (RUU PDP). Langkah ini diambil mengingat semakin banyaknya kasus kebocoran data yang merugikan masyarakat.</p><p>Ketua panja menyebutkan bahwa regulasi ini akan memberikan sanksi tegas bagi pengelola data yang lalai dalam menjaga keamanan informasi pengguna. Diharapkan undang-undang ini dapat disahkan dalam masa sidang kali ini.</p>',
                'kategori_slug' => 'nasional',
                'gambar' => 'berita/sampul/nasional.png'
            ],
            [
                'judul' => 'Pemerintah Targetkan Pertumbuhan Ekonomi 5.2% di Kuartal Depan',
                'ringkasan' => 'Menteri Keuangan optimis bahwa konsumsi domestik dan investasi asing akan menjadi motor penggerak ekonomi nasional.',
                'isi' => '<p>Pemerintah Indonesia memproyeksikan pertumbuhan ekonomi yang stabil di angka 5.2 persen untuk kuartal mendatang. Optimisme ini didorong oleh membaiknya angka ekspor komoditas dan stabilitas inflasi yang terjaga di level aman.</p><p>Berbagai insentif fiskal terus disiapkan untuk menarik minat investor global masuk ke sektor manufaktur dan teknologi hijau di tanah air.</p>',
                'kategori_slug' => 'nasional',
                'gambar' => 'berita/sampul/nasional.png'
            ],
            // Kategori Internasional
            [
                'judul' => 'KTT G20 Fokus pada Stabilitas Rantai Pasok Global',
                'ringkasan' => 'Para pemimpin dunia berkumpul untuk membahas solusi atas gangguan distribusi logistik internasional pasca pandemi.',
                'isi' => '<p>Pertemuan puncak G20 yang berlangsung pekan ini memberikan perhatian khusus pada kerentanan rantai pasok global. Konflik geopolitik dan perubahan iklim diidentifikasi sebagai risiko utama yang dapat menghambat pertumbuhan ekonomi dunia.</p><p>Kesepakatan mengenai diversifikasi sumber energi dan percepatan transformasi digital menjadi poin penting dalam deklarasi bersama yang ditandatangani oleh para delegasi.</p>',
                'kategori_slug' => 'internasional',
                'gambar' => 'berita/sampul/internasional.png'
            ],
            [
                'judul' => 'PBB Serukan Gencatan Senjata Kemanusiaan di Zona Konflik',
                'ringkasan' => 'Sekretaris Jenderal PBB mendesak semua pihak yang bertikai untuk memberikan akses bantuan medis bagi warga sipil.',
                'isi' => '<p>Perserikatan Bangsa-Bangsa (PBB) kembali mengeluarkan seruan keras terkait krisis kemanusiaan yang semakin memburuk di beberapa wilayah konflik dunia. Fokus utama saat ini adalah memastikan bantuan makanan dan obat-obatan dapat mencapai wilayah terdampak tanpa hambatan.</p><p>Diplomasi lintas batas sedang digalakkan untuk mencapai solusi damai jangka panjang yang berkelanjutan.</p>',
                'kategori_slug' => 'internasional',
                'gambar' => 'berita/sampul/internasional.png'
            ],
            // Kategori Hukum
            [
                'judul' => 'MA Keluarkan Surat Edaran Terkait Disiplin Hakim',
                'ringkasan' => 'Mahkamah Agung memperketat pengawasan internal guna menjaga integritas dan profesionalitas aparat penegak hukum.',
                'isi' => '<p>Dalam upaya meningkatkan kepercayaan publik, Mahkamah Agung (MA) merilis Surat Edaran terbaru yang mengatur tentang pedoman perilaku dan disiplin hakim di lingkungan peradilan umum. Langkah ini mencakup audit kinerja rutin dan mekanisme pelaporan pelanggaran yang lebih transparan.</p><p>Reformasi hukum di level internal peradilan menjadi prioritas utama MA di tahun ini.</p>',
                'kategori_slug' => 'hukum',
                'gambar' => 'berita/sampul/hukum.png'
            ],
            [
                'judul' => 'Pakar Hukum Soroti Pentingnya Digital Evidence dalam Persidangan',
                'ringkasan' => 'Pemanfaatan barang bukti digital memerlukan regulasi teknis yang lebih spesifik untuk menjamin validitas di muka sidang.',
                'isi' => '<p>Perkembangan teknologi informasi menuntut adanya adaptasi dalam hukum acara pidana, khususnya terkait penanganan alat bukti digital. Para ahli hukum berpendapat bahwa standarisasi forensik digital harus diperkuat agar bukti tersebut sah dan tidak terbantahkan dalam proses litigasi.</p><p>Pendidikan hukum bagi praktisi mengenai aspek teknologi menjadi sangat krusial saat ini.</p>',
                'kategori_slug' => 'hukum',
                'gambar' => 'berita/sampul/hukum.png'
            ],
        ];

        foreach ($news as $n) {
            $catSlug = $n['kategori_slug'];
            $catId = $categoryIds[$catSlug];
            $catName = $categories[$catSlug];

            $beritaId = DB::table('berita')->insertGetId([
                'judul' => $n['judul'],
                'slug' => Str::slug($n['judul']),
                'ringkasan' => $n['ringkasan'],
                'isi' => $n['isi'],
                'penulis_id' => $penulisId,
                'gambar_utama' => $n['gambar'],
                'kategori' => $catName,
                'unggulan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('berita_memiliki_kategori')->insert([
                'berita_id' => $beritaId,
                'kategori_id' => $catId
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not implemented to avoid clearing all news
    }
};
