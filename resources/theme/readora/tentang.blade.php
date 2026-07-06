@extends('tema::layout')

@section('title', 'About Us')

@section('styles')
<style>
    .about-header {
        background-color: var(--purple-dark);
        padding: 180px 0 100px;
        color: #fff;
        text-align: center;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-image {
        position: relative;
    }

    .about-main-img {
        width: 100%;
        border-radius: 40px;
        box-shadow: var(--shadow-hover);
        position: relative;
        z-index: 2;
    }

    .about-shape {
        position: absolute;
        top: -30px; left: -30px;
        width: 100px; height: 100px;
        background: var(--primary-grad);
        border-radius: 20px;
        z-index: 1;
        animation: float 4s infinite;
    }

    .about-content h2 { font-size: 40px; margin-bottom: 25px; }
    .about-content p { font-size: 18px; color: var(--text-muted); margin-bottom: 25px; line-height: 1.8; }

    .value-card {
        padding: 30px;
        background: var(--bg-light);
        border-radius: 25px;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .value-card:hover {
        background: #fff;
        box-shadow: var(--shadow);
        border-color: var(--primary);
        transform: translateY(-5px);
    }
</style>
@endsection

@section('konten')

<!-- Header -->
<section class="about-header">
    <div class="container">
        <h1 style="font-size: 56px; color: #fff;">Modern Agency with Traditional Values.</h1>
    </div>
</section>

<!-- Content -->
<section class="section-padding">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <div class="about-shape"></div>
                <img src="https://images.unsplash.com/photo-1522071823907-2c97441fe9a0?auto=format&fit=crop&w=800&q=80" class="about-main-img" alt="About">
            </div>
            <div class="about-content">
                <span style="color: var(--primary); font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 15px;">Who We Are</span>
                <h2>Crafting Digital Stories Since 2012</h2>
                <p>We are a team of designers, developers, and strategists who believe that digital experiences should be both beautiful and functional.</p>
                <p>Our philosophy is rooted in user-centric design and technical excellence. We don't just build websites; we build brand identities that stand the test of time.</p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 40px;">
                    <div class="value-card">
                        <i class="fas fa-heart" style="color: var(--primary); font-size: 24px; margin-bottom: 15px;"></i>
                        <h4>Passion</h4>
                        <p style="font-size: 14px; margin-bottom: 0;">We love what we do, and it shows in every pixel.</p>
                    </div>
                    <div class="value-card">
                        <i class="fas fa-rocket" style="color: var(--purple); font-size: 24px; margin-bottom: 15px;"></i>
                        <h4>Innovation</h4>
                        <p style="font-size: 14px; margin-bottom: 0;">Always pushing boundaries with modern tech.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team CTA -->
<section class="section-padding bg-light">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 40px; margin-bottom: 30px;">Let's work together.</h2>
        <p style="max-width: 600px; margin: 0 auto 40px;">We're currently accepting new projects and would love to hear about yours.</p>
        <a href="/kontak" class="btn-cmn">Get in Touch</a>
    </div>
</section>

@endsection
