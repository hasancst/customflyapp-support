@extends('tema::layout')

@section('title', 'Kebijakan Privasi')

@section('konten')
<div class="policy-page">
    <div style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 100px 8%; text-align: center; color: #fff; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 1;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px; line-height: 1;">Kebijakan Privasi</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 900px; margin: 0 auto; line-height: 1.6; font-weight: 500;">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </div>

    <div class="container" style="margin-top: 50px; margin-bottom: 100px;">
        <div style="background: #fff; padding: 60px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid var(--border); max-width: 1000px; margin: 0 auto;">
            <div style="color: var(--text-main); line-height: 1.8;">
                <h2 style="color: var(--primary); margin-bottom: 25px;">Pendahuluan</h2>
                <p style="margin-bottom: 30px;">
                    Selamat datang di {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }}. Kami sangat menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda saat menggunakan situs kami.
                </p>

                <h3 style="margin-bottom: 20px;">1. Informasi yang Kami Kumpulkan</h3>
                <p style="margin-bottom: 20px;">Kami mengumpulkan informasi minimal yang diperlukan untuk meningkatkan pengalaman Anda, seperti:</p>
                <ul style="margin-bottom: 30px; padding-left: 20px;">
                    <li>Data log: Alamat IP, jenis browser, halaman yang dikunjungi.</li>
                    <li>Informasi kontak: Nama dan email jika Anda berlangganan newsletter atau mengisi formulir kontak.</li>
                    <li>Cookie: Untuk mengingat preferensi navigasi Anda.</li>
                </ul>

                <h3 style="margin-bottom: 20px;">2. Penggunaan Informasi</h3>
                <p style="margin-bottom: 30px;">
                    Informasi yang kami kumpulkan hanya digunakan untuk mengirimkan update konten, menjawab pertanyaan Anda lewat formulir kontak, dan menganalisis performa situs untuk perbaikan layanan di masa mendatang.
                </p>

                <h3 style="margin-bottom: 20px;">3. Perlindungan Data</h3>
                <p style="margin-bottom: 30px;">
                    Kami menerapkan langkah-langkah keamanan standar industri untuk menjaga data pribadi Anda dari akses tidak sah, pengubahan, pengungkapan, atau penghancuran yang tidak semestinya.
                </p>

                <h3 style="margin-bottom: 20px;">4. Berbagi Informasi dengan Pihak Ketiga</h3>
                <p style="margin-bottom: 30px;">
                    Kami tidak menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga. Kami hanya berbagi informasi jika diwajibkan oleh hukum yang berlaku di wilayah Negara Kesatuan Republik Indonesia.
                </p>

                <h3 style="margin-bottom: 20px;">5. Perubahan Kebijakan</h3>
                <p style="margin-bottom: 30px;">
                    {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }} berhak mengubah kebijakan privasi ini sewaktu-waktu. Kami akan memberitahukan perubahan signifikan melalui halaman ini.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
