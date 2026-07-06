@extends('tema::layout')

@section('title', 'Tentang Kami')

@section('konten')
<div class="about-page">
    <div style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 120px 8%; text-align: center; color: #fff; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 1;">
            <h1 style="font-size: 4.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -3px; line-height: 1;">Tentang Kami</h1>
            <p style="font-size: 1.5rem; opacity: 0.9; max-width: 900px; margin: 0 auto; line-height: 1.6; font-weight: 500;">Mengenal lebih dekat portal informasi hukum terpercaya di Indonesia.</p>
        </div>
    </div>

    <div class="container" style="margin-top: -50px; margin-bottom: 100px; position: relative; z-index: 2;">
        <div style="background: #fff; padding: 60px; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); border: 1px solid var(--border);">
            <div style="grid-template-columns: 1fr 1fr; display: grid; gap: 60px; align-items: center;">
                <div>
                    <h2 style="font-size: 2.5rem; color: var(--primary); margin-bottom: 25px;">Visi & Misi Kami</h2>
                    <p style="font-size: 1.1rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 20px;">
                        {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }} hadir sebagai solusi bagi masyarakat yang ingin memahami hukum dengan cara yang lebih sederhana dan menyenangkan. Kami percaya bahwa setiap warga negara berhak mendapatkan akses informasi hukum yang akurat dan mudah dipahami.
                    </p>
                    <p style="font-size: 1.1rem; color: var(--text-muted); line-height: 1.8;">
                        Visi kami adalah menjadi media edukasi hukum nomor satu di Indonesia yang mampu mencerdaskan kehidupan bangsa melalui literasi hukum yang inklusif.
                    </p>
                </div>
                <div style="border-radius: 20px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.1);">
                    <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80" alt="Tentang Kami" style="width: 100%; display: block;">
                </div>
            </div>

            <hr style="margin: 60px 0; border: none; border-top: 1px solid var(--border);">

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; text-align: center;">
                <div>
                    <div style="width: 70px; height: 70px; background: #ebf5ff; color: var(--primary); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 20px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 style="font-size: 1.4rem; margin-bottom: 15px;">Terpercaya</h4>
                    <p style="color: var(--text-muted); line-height: 1.6;">Informasi yang kami sajikan telah melalui riset mendalam dan divalidasi oleh pakar hukum.</p>
                </div>
                <div>
                    <div style="width: 70px; height: 70px; background: #fff7ed; color: #f59e0b; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 20px;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 style="font-size: 1.4rem; margin-bottom: 15px;">Aktual</h4>
                    <p style="color: var(--text-muted); line-height: 1.6;">Menyajikan berita hukum terbaru dan perubahan regulasi secara real-time.</p>
                </div>
                <div>
                    <div style="width: 70px; height: 70px; background: #f0fdf4; color: #22c55e; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 20px;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 style="font-size: 1.4rem; margin-bottom: 15px;">User Friendly</h4>
                    <p style="color: var(--text-muted); line-height: 1.6;">Bahasa hukum yang berat kami kemas menjadi konten yang ringan dan mudah dicerna.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
