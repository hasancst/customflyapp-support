@extends('tema::layout')

@section('title', 'Syarat & Ketentuan')

@section('konten')
<div class="terms-page">
    <div style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 100px 8%; text-align: center; color: #fff; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 1;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px; line-height: 1;">Syarat & Ketentuan</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 900px; margin: 0 auto; line-height: 1.6; font-weight: 500;">Ketentuan penggunaan layanan {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }}</p>
        </div>
    </div>

    <div class="container" style="margin-top: 50px; margin-bottom: 100px;">
        <div style="background: #fff; padding: 60px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid var(--border); max-width: 1000px; margin: 0 auto;">
            <div style="color: var(--text-main); line-height: 1.8;">
                <h2 style="color: var(--primary); margin-bottom: 25px;">Penerimaan Ketentuan</h2>
                <p style="margin-bottom: 30px;">
                    Dengan mengakses dan menggunakan situs {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }}, Anda dianggap telah membaca, memahami, dan menyetujui semua syarat dan ketentuan yang berlaku di bawah ini.
                </p>

                <h3 style="margin-bottom: 20px;">1. Hak Kekayaan Intelektual</h3>
                <p style="margin-bottom: 30px;">
                    Seluruh konten yang dipublikasikan di situs ini (artikel, gambar, video, logo) adalah milik {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }} dilindungi oleh Undang-Undang Hak Cipta. Penggunaan kembali konten untuk tujuan komersial tanpa izin tertulis adalah dilarang.
                </p>

                <h3 style="margin-bottom: 20px;">2. Batasan Tanggung Jawab</h3>
                <p style="margin-bottom: 30px;">
                    Informasi yang disajikan di situs ini ditujukan untuk edukasi dan informasi umum, bukan saran hukum formal. Hasil konsultasi atau tindakan yang diambil berdasarkan konten situs ini sepenuhnya menjadi tanggung jawab pengguna.
                </p>

                <h3 style="margin-bottom: 20px;">3. Tautan Pihak Ketiga</h3>
                <p style="margin-bottom: 30px;">
                    Situs kami mungkin memuat tautan ke situs web pihak ketiga. Kami tidak bertanggung jawab atas isi, kebijakan privasi, atau praktik yang dilakukan oleh situs-situs tersebut.
                </p>

                <h3 style="margin-bottom: 20px;">4. Penggunaan yang Dilarang</h3>
                <p style="margin-bottom: 20px;">Anda dilarang menggunakan situs ini untuk:</p>
                <ul style="margin-bottom: 30px; padding-left: 20px;">
                    <li>Menyebarkan informasi palsu atau hoaks.</li>
                    <li>Melakukan tindakan yang dapat merusak infrastruktur server kami.</li>
                    <li>Mencuri data pengguna lain atau melakukan peretasan.</li>
                </ul>

                <h3 style="margin-bottom: 20px;">5. Hukum yang Mengatur</h3>
                <p style="margin-bottom: 30px;">
                    Syarat dan ketentuan ini diatur dan ditafsirkan sesuai dengan hukum yang berlaku di Republik Indonesia.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
