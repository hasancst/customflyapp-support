@extends('tema::layout')

@section('title', 'About Us | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">About <span>Our Agency</span></h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto;">Pioneering the future of bespoke manufacturing with cutting-edge technology and unparalleled craftsmanship.</p>
    </div>
</section>

<section class="about-content" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div class="reveal">
                <div class="image-wrapper" style="border-radius: 24px; overflow: hidden; border: 1px solid var(--glass-border); position: relative;">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80" alt="Innovation" style="width: 100%; display: block;">
                    <div class="glass-card" style="position: absolute; bottom: 20px; left: 20px; padding: 1rem;">
                        <strong>10+ Years</strong> of Innovation
                    </div>
                </div>
            </div>
            <div class="reveal delay-1">
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Our Mission</h2>
                <p style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 1.1rem; line-height: 1.8;">At {{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }}, we believe that every great idea deserves to be realized with precision and speed. Our mission is to bridge the gap between imagination and reality by providing world-class manufacturing solutions to innovators across the globe.</p>
                <div style="display: flex; gap: 2rem; margin-top: 2rem;">
                    <div>
                        <h3 style="color: var(--secondary); font-size: 2rem;">500+</h3>
                        <p>Projects Delivered</p>
                    </div>
                    <div>
                        <h3 style="color: var(--secondary); font-size: 2rem;">99%</h3>
                        <p>Client Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
