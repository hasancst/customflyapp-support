@extends('tema::layout')

@section('title', 'Hubungi Kami')

@section('konten')
<div class="contact-page">
    <!-- Contact Hero - Truly Full Width -->
    <div style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 120px 8%; margin-bottom: 60px; text-align: center; color: #fff; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 1;">
            <h1 style="font-size: 4.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -3px; line-height: 1;">Get In Touch</h1>
            <p style="font-size: 1.5rem; opacity: 0.9; max-width: 900px; margin: 0 auto; line-height: 1.6; font-weight: 500;">Punya pertanyaan atau ingin berkonsultasi? Kami siap membantu Anda dengan solusi hukum terbaik.</p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 100px;">
        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; align-items: start;">
            
            <!-- Contact Info -->
            <div>
                <div style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid var(--border);">
                    <h3 style="font-size: 1.5rem; margin-bottom: 30px; color: var(--primary);">Informasi Kontak</h3>
                    
                    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                        <div style="width: 50px; height: 50px; background: #ebf5ff; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--text-main); margin-bottom: 5px;">Alamat Kantor</div>
                            <div style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">{{ $pengaturan['alamat'] ?? 'Jakarta, Indonesia' }}</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                        <div style="width: 50px; height: 50px; background: #fff7ed; color: #f59e0b; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--text-main); margin-bottom: 5px;">Email Support</div>
                            <div style="color: var(--text-muted); font-size: 0.95rem;">{{ $pengaturan['email_admin'] ?? 'kontak@pinterhukum.id' }}</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: #f0fdf4; color: #22c55e; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--text-main); margin-bottom: 5px;">Telepon / WA</div>
                            <div style="color: var(--text-muted); font-size: 0.95rem;">{{ $pengaturan['no_hp'] ?? '+62 812 3456 789' }}</div>
                        </div>
                    </div>

                    <hr style="margin: 40px 0; border: none; border-top: 1px solid var(--border);">

                    <h4 style="font-weight: 700; margin-bottom: 20px;">Ikuti Kami</h4>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: #3b5998; color: #fff; display: flex; align-items: center; justify-content: center; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: #e1306c; color: #fff; display: flex; align-items: center; justify-content: center; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: #1da1f2; color: #fff; display: flex; align-items: center; justify-content: center; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <div style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid var(--border);">
                    @if(session('berhasil'))
                        <div style="background: #f0fdf4; color: #166534; padding: 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; border-left: 5px solid #22c55e;">
                            <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                            <span style="font-weight: 600;">{{ session('berhasil') }}</span>
                        </div>
                    @endif

                    <form action="/kontak" method="POST">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; margin-bottom: 10px; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Nama Lengkap</label>
                                <input type="text" name="nama" required style="width: 100%; padding: 15px; border-radius: 12px; border: 2px solid #f1f5f9; background: #f8fafc; font-family: inherit; transition: all 0.3s; outline: none;" placeholder="Masukkan nama Anda" onfocus="this.style.borderColor='var(--primary)'; this.style.background='#fff'" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 10px; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Alamat Email</label>
                                <input type="email" name="email" required style="width: 100%; padding: 15px; border-radius: 12px; border: 2px solid #f1f5f9; background: #f8fafc; font-family: inherit; transition: all 0.3s; outline: none;" placeholder="email@contoh.com" onfocus="this.style.borderColor='var(--primary)'; this.style.background='#fff'" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'">
                            </div>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Subjek / Perihal</label>
                            <input type="text" name="perihal" required style="width: 100%; padding: 15px; border-radius: 12px; border: 2px solid #f1f5f9; background: #f8fafc; font-family: inherit; transition: all 0.3s; outline: none;" placeholder="Apa yang ingin Anda bicarakan?" onfocus="this.style.borderColor='var(--primary)'; this.style.background='#fff'" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'">
                        </div>

                        <div style="margin-bottom: 30px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Pesan Anda</label>
                            <textarea name="pesan" required rows="6" style="width: 100%; padding: 15px; border-radius: 12px; border: 2px solid #f1f5f9; background: #f8fafc; font-family: inherit; transition: all 0.3s; outline: none; resize: none;" placeholder="Tuliskan pesan lengkap Anda di sini..." onfocus="this.style.borderColor='var(--primary)'; this.style.background='#fff'" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'"></textarea>
                        </div>

                        <button type="submit" style="width: 100%; padding: 18px; background: var(--primary); color: #fff; border: none; border-radius: 15px; font-weight: 800; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.3s; box-shadow: 0 10px 20px rgba(1, 74, 122, 0.2);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(1, 74, 122, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(1, 74, 122, 0.2)'">
                            Kirim Pesan Sekarang <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
