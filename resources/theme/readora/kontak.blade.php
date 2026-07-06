@extends('tema::layout')

@section('title', 'Get in Touch')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div style="text-align: center; max-width: 700px; margin: 0 auto 60px;">
            <span style="color: var(--primary); font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">Contact Us</span>
            <h1 style="margin-top: 10px; font-size: 40px;">Have a project in mind? Let's talk.</h1>
            <p style="color: var(--text-muted); font-size: 18px;">Send me a message and I'll get back to you within 24 hours.</p>
        </div>

        <div class="hero-grid" style="align-items: flex-start;">
            <div style="background: var(--white); padding: 50px; border-radius: 30px; box-shadow: var(--shadow);">
                @if(session('berhasil'))
                    <div style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                        {{ session('berhasil') }}
                    </div>
                @endif
                
                <form action="/kontak" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">Your Name</label>
                            <input type="text" name="nama" required style="width: 100%; padding: 12px 20px; border: 1px solid var(--border); border-radius: 10px; background: #f8f8ff; outline: none; transition: 0.3s;" placeholder="Full Name">
                        </div>
                        <div>
                            <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">Email Address</label>
                            <input type="email" name="email" required style="width: 100%; padding: 12px 20px; border: 1px solid var(--border); border-radius: 10px; background: #f8f8ff; outline: none; transition: 0.3s;" placeholder="example@mail.com">
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">Subject</label>
                        <input type="text" name="subjek" required style="width: 100%; padding: 12px 20px; border: 1px solid var(--border); border-radius: 10px; background: #f8f8ff; outline: none; transition: 0.3s;" placeholder="Project inquiry">
                    </div>
                    <div style="margin-bottom: 30px;">
                        <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">Message</label>
                        <textarea name="pesan" rows="5" required style="width: 100%; padding: 12px 20px; border: 1px solid var(--border); border-radius: 10px; background: #f8f8ff; outline: none; transition: 0.3s; resize: none;" placeholder="Tell me more about your project..."></textarea>
                    </div>
                    <button type="submit" class="btn-cmn" style="width: 100%; border: none; cursor: pointer;">Send Message</button>
                </form>
            </div>

            <div style="padding-left: 30px;">
                <div style="margin-bottom: 40px;">
                    <h3 style="margin-bottom: 20px;">Contact Info</h3>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 25px;">
                        <div style="width: 50px; height: 50px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); box-shadow: var(--shadow); font-size: 1.2rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5 style="margin-bottom: 3px;">Address</h5>
                            <p style="color: var(--text-muted); font-size: 14px;">{{ $pengaturan['alamat'] ?? 'Jakarta, Indonesia' }}</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 25px;">
                        <div style="width: 50px; height: 50px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--secondary); box-shadow: var(--shadow); font-size: 1.2rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 style="margin-bottom: 3px;">Email</h5>
                            <p style="color: var(--text-muted); font-size: 14px;">{{ $pengaturan['email_admin'] ?? 'hello@example.com' }}</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="width: 50px; height: 50px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #44D7B6; box-shadow: var(--shadow); font-size: 1.2rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h5 style="margin-bottom: 3px;">Phone</h5>
                            <p style="color: var(--text-muted); font-size: 14px;">+62 812 3456 7890</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 style="margin-bottom: 20px;">Follow Me</h3>
                    <div style="display: flex; gap: 15px;">
                        @if(isset($pengaturan['sosmed_facebook']) && $pengaturan['sosmed_facebook'])
                            <a href="{{ $pengaturan['sosmed_facebook'] }}" target="_blank" style="width: 40px; height: 40px; background: var(--purple-dark); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_twitter']) && $pengaturan['sosmed_twitter'])
                            <a href="{{ $pengaturan['sosmed_twitter'] }}" target="_blank" style="width: 40px; height: 40px; background: var(--purple-dark); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_instagram']) && $pengaturan['sosmed_instagram'])
                            <a href="{{ $pengaturan['sosmed_instagram'] }}" target="_blank" style="width: 40px; height: 40px; background: var(--purple-dark); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_linkedin']) && $pengaturan['sosmed_linkedin'])
                            <a href="{{ $pengaturan['sosmed_linkedin'] }}" target="_blank" style="width: 40px; height: 40px; background: var(--purple-dark); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_youtube']) && $pengaturan['sosmed_youtube'])
                            <a href="{{ $pengaturan['sosmed_youtube'] }}" target="_blank" style="width: 40px; height: 40px; background: var(--purple-dark); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
