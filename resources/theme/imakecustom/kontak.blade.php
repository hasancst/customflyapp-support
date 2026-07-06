@extends('tema::layout')

@section('title', 'Contact Us | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="contact-page">
    <div class="container">
        <div class="text-center reveal" style="margin-bottom: 4rem; padding-top: 10rem;">
            <h1 class="section-title">Get in <span>Touch</span></h1>
            <p style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">Have a project in mind? Our team of experts is ready to help you navigate your journey from concept to production.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-info-cards">
                <div class="info-card reveal">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-text">
                        <h4>Location</h4>
                        <p>{{ $pengaturan['alamat'] ?? 'Silicon Valley, CA' }}</p>
                    </div>
                </div>
                <div class="info-card reveal delay-1">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p>{{ $pengaturan['email_admin'] ?? 'hello@imakecustom.com' }}</p>
                    </div>
                </div>
                <div class="info-card reveal delay-2">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-text">
                        <h4>WhatsApp</h4>
                        <p>+{{ $pengaturan['whatsapp'] ?? '628123456789' }}</p>
                    </div>
                </div>
                
                @if(!empty($pengaturan['sosmed_linkedin']) || !empty($pengaturan['sosmed_twitter']) || !empty($pengaturan['sosmed_facebook']) || !empty($pengaturan['sosmed_instagram']) || !empty($pengaturan['sosmed_youtube']))
                <div class="social-links-large reveal delay-3">
                    @if(!empty($pengaturan['sosmed_linkedin']) && $pengaturan['sosmed_linkedin'] !== '#')
                        <a href="{{ $pengaturan['sosmed_linkedin'] }}" target="_blank" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_twitter']) && $pengaturan['sosmed_twitter'] !== '#')
                        <a href="{{ $pengaturan['sosmed_twitter'] }}" target="_blank" class="social-btn"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_facebook']) && $pengaturan['sosmed_facebook'] !== '#')
                        <a href="{{ $pengaturan['sosmed_facebook'] }}" target="_blank" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_instagram']) && $pengaturan['sosmed_instagram'] !== '#')
                        <a href="{{ $pengaturan['sosmed_instagram'] }}" target="_blank" class="social-btn"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_youtube']) && $pengaturan['sosmed_youtube'] !== '#')
                        <a href="{{ $pengaturan['sosmed_youtube'] }}" target="_blank" class="social-btn"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
                @endif
            </div>

            <div class="contact-form-wrapper reveal delay-2">
                @if(session('berhasil'))
                    <div class="alert alert-success">
                        {{ session('berhasil') }}
                    </div>
                @endif

                <form action="/kontak" method="POST" class="glass-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="nama" required placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" required placeholder="john@example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="perihal" required placeholder="Project Inquiry">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="pesan" rows="5" required placeholder="Tell us more about your project..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="map-section reveal">
    <div class="container">
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d101408.23303641775!2d-122.15201193356875!3d37.41332009277028!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb6a132200199%3A0xc3f669f061031332!2sSilicon%20Valley%2C%20CA!5e0!3m2!1sen!2sus!4v1705970000000!5m2!1sen!2sus" 
                width="100%" height="450" style="border:0; border-radius: 24px;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .contact-page { padding-bottom: 8rem; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 4rem; }
    
    .contact-info-cards { display: flex; flex-direction: column; gap: 1.5rem; }
    .info-card { 
        background: var(--bg-card); 
        padding: 2rem; 
        border-radius: 20px; 
        border: 1px solid var(--glass-border);
        display: flex;
        gap: 1.5rem;
        align-items: center;
        transition: var(--transition);
    }
    .info-card:hover { border-color: var(--primary); transform: translateX(10px); }
    .info-icon { 
        width: 60px; height: 60px; 
        background: rgba(99, 102, 241, 0.1); 
        color: var(--primary); 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.5rem;
    }
    .info-text h4 { margin-bottom: 0.3rem; font-size: 1.1rem; }
    .info-text p { color: var(--text-muted); }

    .social-links-large { display: flex; gap: 1rem; margin-top: 1rem; }
    .social-btn { 
        width: 50px; height: 50px; 
        background: var(--glass); 
        border: 1px solid var(--glass-border); 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        transition: var(--transition);
    }
    .social-btn:hover { background: var(--primary); transform: translateY(-5px); }

    .glass-form { 
        background: var(--bg-card); 
        padding: 3rem; 
        border-radius: 30px; 
        border: 1px solid var(--glass-border);
    }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.8rem; font-weight: 500; font-size: 0.9rem; }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 1rem 1.5rem;
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        color: white;
        font-family: inherit;
        transition: var(--transition);
    }
    .form-group input:focus, .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981;
        color: #10b981;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .map-section { padding-bottom: 8rem; }
    .map-container { border: 1px solid var(--glass-border); border-radius: 24px; padding: 10px; background: var(--glass); }

    @media (max-width: 1024px) {
        .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
    }
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .glass-form { padding: 2rem; }
    }
</style>
@endsection
