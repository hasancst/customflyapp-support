@extends('tema::layout')

@section('title', $pengaturan['nama_situs'] ?? 'iMakeCustom | Premium Bespoke Solutions')

@section('konten')
    <section class="hero" id="slide">
        <div class="container hero-content">
            @if(isset($slideshow) && $slideshow->isNotEmpty())
                @php $slide = $slideshow->first(); @endphp
                <div class="hero-text">
                    <h1 class="reveal">{!! $slide->judul !!}</h1>
                    <p class="reveal delay-1">{{ $slide->deskripsi }}</p>
                    <div class="hero-btns reveal delay-2">
                        <a href="{{ $slide->url ?? '#contact' }}" class="btn-primary">{{ $slide->badge_1 ?? 'Start Your Project' }}</a>
                        <a href="#portfolio" class="btn-secondary">{{ $slide->badge_2 ?? 'View Showcase' }}</a>
                    </div>
                </div>
                <div class="hero-visual reveal delay-3">
                    <div class="image-wrapper">
                        <img src="/storage/{{ $slide->gambar }}" alt="{{ $slide->judul }}">
                        <div class="glass-card floating">
                            <div class="status-dot"></div>
                            <span>Production Live</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="hero-text">
                    <h1 class="reveal">Where Vision Meets <span>Precision</span></h1>
                    <p class="reveal delay-1">Turn your boldest concepts into reality with our state-of-the-art custom manufacturing platform. From rapid prototyping to full-scale production.</p>
                    <div class="hero-btns reveal delay-2">
                        <a href="#contact" class="btn-primary">Start Your Project</a>
                        <a href="#portfolio" class="btn-secondary">View Showcase</a>
                    </div>
                </div>
                <div class="hero-visual reveal delay-3">
                    <div class="image-wrapper">
                        <img src="{{ asset('theme/imakecustom/img/hero.png') }}" alt="Futuristic Manufacturing Hub">
                        <div class="glass-card floating">
                            <div class="status-dot"></div>
                            <span>Production Live</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container text-center">
            <h2 class="section-title">End-to-End Solutions</h2>
            <div class="features-grid">
                @if(isset($layanans) && count($layanans) > 0)
                    @foreach($layanans as $l)
                        <div class="feature-card reveal">
                            <div class="feature-icon">
                                @if(str_starts_with($l->ikon, 'fa'))
                                    <i class="{{ $l->ikon }}"></i>
                                @else
                                    @switch($l->ikon)
                                        @case('cube')
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('cogs')
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('crosshairs')
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @default
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @endswitch
                                @endif
                            </div>
                            <h3>{{ $l->judul }}</h3>
                            <p>{{ $l->deskripsi }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="feature-card reveal">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3>Prototyping</h3>
                        <p>Rapid iterative design using 3D printing and precision CNC machining.</p>
                    </div>
                    <div class="feature-card reveal delay-1">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3>Smart Batching</h3>
                        <p>Optimized small-to-mid scale manufacturing with intelligent supply chains.</p>
                    </div>
                    <div class="feature-card reveal delay-2">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3>Laser Precision</h3>
                        <p>Ultra-accurate laser cutting and engraving for complex geometries.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="portfolio" class="portfolio">
        <div class="container section-header">
            <div>
                <h2 class="section-title">The Showcase</h2>
                <p>Recent masterpieces delivered to our global clients.</p>
            </div>
            <div class="portfolio-filter">
                <button class="active" data-filter="all">All</button>
                @php
                    $categories = isset($portofolios) ? $portofolios->pluck('kategori')->filter()->unique() : collect([]);
                @endphp
                @foreach($categories as $cat)
                    <button data-filter="{{ $cat }}">{{ $cat }}</button>
                @endforeach
            </div>
        </div>
        <div class="portfolio-grid">
            @if(isset($portofolios) && count($portofolios) > 0)
                @foreach($portofolios as $p)
                    <div class="portfolio-item group reveal" data-category="{{ $p->kategori }}">
                        <img src="/storage/{{ $p->gambar }}" alt="{{ $p->judul }}">
                        <div class="overlay">
                            <h4>{{ $p->judul }}</h4>
                            <p>{{ $p->deskripsi }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="portfolio-item group reveal">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80" alt="Tech Hub">
                    <div class="overlay">
                        <h4>Cyber-Sleeves</h4>
                        <p>Aerospace-grade custom housing</p>
                    </div>
                </div>
                <div class="portfolio-item group reveal delay-1">
                    <img src="https://images.unsplash.com/photo-1531746790731-6c087fecd05a?auto=format&fit=crop&w=800&q=80" alt="Robotics">
                    <div class="overlay">
                        <h4>Nexus Artic</h4>
                        <p>Custom robotics exoskeleton</p>
                    </div>
                </div>
                <div class="portfolio-item group reveal delay-2">
                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80" alt="Futuristic">
                    <div class="overlay">
                        <h4>Aero-Dynamics</h4>
                        <p>Wind-tunnel tested custom parts</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section id="faq" class="faq">
        <div class="container">
            <h2 class="section-title text-center">Frequently Asked Questions</h2>
            <div class="faq-grid">
                @if(isset($faqs) && count($faqs) > 0)
                    @foreach($faqs as $f)
                        <div class="faq-item reveal">
                            <div class="faq-question">
                                <h4>{{ $f->pertanyaan }}</h4>
                                <div class="faq-icon"></div>
                            </div>
                            <div class="faq-answer">
                                <p>{{ $f->jawaban }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="faq-item reveal">
                        <div class="faq-question">
                            <h4>How do I start a project?</h4>
                            <div class="faq-icon"></div>
                        </div>
                        <div class="faq-answer">
                            <p>Simply click the "Request a Quote" button and our team will get back to you within 24 hours.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="contact" class="cta-section">
        <div class="container">
            <div class="cta-card reveal">
                <h2>Contact Us</h2>
                <p>Join the future of manufacturing. Let's build something extraordinary together.</p>
                <a href="mailto:{{ $pengaturan['email_admin'] ?? 'admin@imakecustom.com' }}" class="btn-primary btn-large">Request a Quote</a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Reveal animation logic (already in main.js, but ensuring it runs on dynamic content if needed)
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection
