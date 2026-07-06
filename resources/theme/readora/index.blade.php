@extends('tema::layout')

@section('title', 'Modern Portfolio & Creative Studio')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Hero Section Override */
    html {
        scroll-behavior: smooth;
    }
    section {
        scroll-margin-top: 80px;
    }
    .hero-readora {
        background-color: var(--purple-dark);
        background-image: radial-gradient(circle at 80% 20%, rgba(94, 51, 209, 0.3) 0%, transparent 40%),
                          radial-gradient(circle at 10% 80%, rgba(247, 112, 98, 0.2) 0%, transparent 40%);
        padding: 180px 0 120px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .hero-text h1 {
        font-size: 64px;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 25px;
        font-weight: 900;
    }

    .hero-text p {
        font-size: 20px;
        opacity: 0.8;
        margin-bottom: 40px;
        max-width: 500px;
    }

    .hero-img-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 480px; /* Ensure enough space for orbit */
    }

    .hero-main-img {
        width: 380px;
        height: 380px;
        border-radius: 50%;
        object-fit: cover;
        border: 8px solid rgba(255,255,255,0.1);
        position: relative;
        z-index: 2;
        box-shadow: 0 0 50px rgba(0,0,0,0.3);
    }

    .img-orbit {
        position: absolute;
        width: 450px;
        height: 450px;
        border: 2px dashed var(--primary);
        border-radius: 50%;
        z-index: 1;
        animation: rotate-center 15s linear infinite;
        opacity: 0.5;
    }

    @keyframes rotate-center {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .floating-badge {
        position: absolute;
        padding: 12px 25px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 15px;
        color: #fff;
        font-weight: 700;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .badge-1 { top: 10%; right: -20px; animation: float 5s ease-in-out infinite; }
    .badge-2 { bottom: 20%; left: -30px; animation: float 6s ease-in-out infinite reverse; }

    /* Specializing Section */
    .service-card {
        padding: 40px;
        background: #fff;
        border-radius: 30px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        text-align: center;
    }

    .service-card:hover {
        transform: translateY(-15px);
        box-shadow: var(--shadow-hover);
    }

    .service-icon {
        width: 80px;
        height: 80px;
        background: var(--bg-light);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 32px;
        color: var(--primary);
        transition: var(--transition);
    }

    .service-card:hover .service-icon {
        background: var(--primary-grad);
        color: #fff;
    }

    /* Portfolio Card Override */
    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }

    .readora-card {
        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .readora-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .card-thumb {
        position: relative;
        height: 280px;
        overflow: hidden;
    }

    .card-thumb img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .readora-card:hover .card-thumb img { transform: scale(1.1); }

    .card-content { padding: 30px; }
    .card-cat {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        margin-bottom: 10px;
        display: block;
    }

    /* Stats Section */
    .stats-section {
        background: var(--primary-grad);
        border-radius: 50px;
        padding: 80px 0;
        color: #fff;
        margin-bottom: 100px;
    }

    .stat-item h2 { font-size: 48px; color: #fff; margin-bottom: 5px; }
    .stat-item p { font-size: 18px; opacity: 0.9; font-weight: 600; }

    /* FAQ Section */
    .faq-item {
        background: var(--bg-light);
        padding: 25px;
        border-radius: 20px;
        margin-bottom: 20px;
        cursor: pointer;
        transition: var(--transition);
        overflow: hidden;
    }

    .faq-item:hover { background: #fff; box-shadow: var(--shadow); }
    .faq-q {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 18px;
        color: var(--purple);
    }
    .faq-a {
        max-height: 0;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0, 1, 0, 1);
        color: var(--text-muted);
        font-size: 16px;
    }
    .faq-item.active .faq-a {
        max-height: 500px;
        margin-top: 15px;
        transition: all 0.5s cubic-bezier(1, 0, 1, 0);
    }
    .faq-item.active .faq-q i {
        transform: rotate(45deg);
        color: var(--primary);
    }
    .faq-q i { transition: var(--transition); }

    @media (max-width: 991px) {
        .hero-grid { grid-template-columns: 1fr; text-align: center; }
        .hero-text p { margin: 0 auto 40px; }
        .hero-text h1 { font-size: 48px; }
        .hero-main-img { width: 300px; height: 300px; }
        .img-orbit { width: 340px; height: 340px; }
    }
</style>
@endsection

@section('konten')

<!-- Hero Section (Dynamic Slideshow) -->
<section class="hero-readora" id="home">
    @if($slideshow->count() > 0)
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach($slideshow as $slide)
            <div class="swiper-slide">
                <div class="container">
                    <div class="hero-grid">
                        <div class="hero-text">
                            <span style="color: var(--primary); font-weight: 800; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 15px;">Creative Portfolio</span>
                            <h1>{{ $slide->judul }}</h1>
                            <p>{{ $slide->deskripsi }}</p>
                            <div style="display: flex; gap: 20px;">
                                <a href="{{ $slide->url ?? '/berita' }}" class="btn-cmn">Explore Now</a>
                                <a href="/kontak" class="btn-cmn btn-outline" style="border-color: #fff; color: #fff;">Let's Talk</a>
                            </div>
                        </div>
                        <div class="hero-img-container">
                            <div class="img-orbit"></div>
                            @php
                                $imgPath = (strpos($slide->gambar, 'http') === 0) ? $slide->gambar : '/storage/' . $slide->gambar;
                            @endphp
                            <img src="{{ $imgPath }}" class="hero-main-img" alt="{{ $slide->judul }}">
                            
                            @if($slide->badge_1)
                            <div class="floating-badge badge-1">
                                <i class="fas fa-bezier-curve" style="color: #f77062;"></i>
                                <span>{{ $slide->badge_1 }}</span>
                            </div>
                            @endif
                            @if($slide->badge_2)
                            <div class="floating-badge badge-2">
                                <i class="fas fa-code" style="color: #5e33d1;"></i>
                                <span>{{ $slide->badge_2 }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Swiper Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    @else
    <!-- Fallback Hero (Static) -->
    <div class="container">
        <div class="hero-grid">
            <div class="hero-text">
                <span style="color: var(--primary); font-weight: 800; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 15px;">Creative Portfolio</span>
                <h1>Building Digital Experiences That Matter.</h1>
                <p>We are a boutique studio specializing in high-end design and innovative web development for forward-thinking brands.</p>
                <div style="display: flex; gap: 20px;">
                    <a href="/berita" class="btn-cmn">View Projects</a>
                    <a href="/kontak" class="btn-cmn btn-outline" style="border-color: #fff; color: #fff;">Let's Talk</a>
                </div>
            </div>
            <div class="hero-img-container">
                <div class="img-orbit"></div>
                @if($unggulan->isNotEmpty())
                    <img src="/storage/{{ $unggulan->first()->gambar_utama }}" class="hero-main-img" alt="Hero">
                @else
                    <img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=600&q=80" class="hero-main-img" alt="Hero">
                @endif
                <div class="floating-badge badge-1">
                    <i class="fas fa-bezier-curve" style="color: #f77062;"></i>
                    <span>UI/UX Design</span>
                </div>
                <div class="floating-badge badge-2">
                    <i class="fas fa-code" style="color: #5e33d1;"></i>
                    <span>Development</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.hero-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
    });

    // FAQ Accordion
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Close all first (optional, for single accordion behavior)
            document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));
            
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
</script>
@endsection


<!-- Services / Specilizing -->
<section class="section-padding bg-light" id="services">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 60px;">
            <h2 style="font-size: 40px; margin-bottom: 20px;">Specializing In</h2>
            <p>From visual identity to technical implementation, we provide end-to-end creative solutions.</p>
        </div>
        
        <div class="portfolio-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
            @forelse($layanans as $l)
            <div class="service-card">
                <div class="service-icon"><i class="{{ $l->ikon ?: 'fas fa-concierge-bell' }}"></i></div>
                <h3>{{ $l->judul }}</h3>
                <p style="margin-top: 15px; color: var(--text-muted);">{{ $l->deskripsi }}</p>
            </div>
            @empty
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-palette"></i></div>
                <h3>Visual Design</h3>
                <p style="margin-top: 15px; color: var(--text-muted);">Crafting unique visual identities and stunning graphics for your brand.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-laptop-code"></i></div>
                <h3>Web Solutions</h3>
                <p style="margin-top: 15px; color: var(--text-muted);">Developing high-performance, responsive websites with modern tech.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-bullhorn"></i></div>
                <h3>Digital Marketing</h3>
                <p style="margin-top: 15px; color: var(--text-muted);">Strategic campaigns that reach your audience and drive results.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="section-padding" id="portfolio">
    <div class="container">
        <div style="margin-bottom: 60px; text-align: center;" id="portfolio-section">
            <h2 style="font-size: 40px; margin-bottom: 15px;">Latest Projects</h2>
            <p style="margin-top: 10px; max-width: 600px; margin-left: auto; margin-right: auto; margin-bottom: 40px;">Explore our finest work categorized by expertise. Click on any tag to filter the projects instantly.</p>
            
            <div style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;" class="portfolio-filters">
                <button onclick="filterProjects('all')" class="btn-cmn filter-btn active" style="padding: 12px 28px; font-size: 14px; border-radius: 50px; font-weight: 600;">
                    Semua Proyek
                </button>
                @foreach($portfolioTags as $tag)
                <button onclick="filterProjects('{{ trim($tag) }}')" class="btn-cmn btn-outline filter-btn" style="padding: 12px 28px; font-size: 14px; border-radius: 50px; text-transform: capitalize; border-color: #0d9488; color: #0d9488; font-weight: 600;">
                    #{{ trim($tag) }}
                </button>
                @endforeach
            </div>
        </div>

        <div class="portfolio-grid" id="project-container">
            @forelse($portofolios as $item)
            <div class="readora-card project-item" data-tags="{{ strtolower($item->tags) }}">
                <div class="card-thumb">
                    @php
                        $imgPath = (strpos($item->gambar, 'http') === 0) ? $item->gambar : '/storage/' . $item->gambar;
                    @endphp
                    <a href="{{ $item->url ?? '#' }}">
                        <img src="{{ $imgPath }}" alt="{{ $item->judul }}">
                    </a>
                </div>
                <div class="card-content">
                    <span class="card-cat">{{ $item->kategori ?? 'Proyek' }}</span>
                    <h3 style="font-size: 22px; margin-bottom: 10px;"><a href="{{ $item->url ?? '#' }}">{{ $item->judul }}</a></h3>
                    
                    @if($item->tags)
                    <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 15px;">
                        @foreach(explode(',', $item->tags) as $tag)
                        <span style="background: #f0fdfa; color: #0d9488; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; cursor: pointer; border: 1px solid #ccfbf1;" onclick="filterProjects('{{ trim($tag) }}')">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 14px; color: var(--text-muted);">{{ $item->klien ?? 'Client' }}</span>
                        <a href="{{ $item->url ?? '#' }}" style="color: #0d9488; font-weight: 700;">View Project <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                <p style="color: var(--text-muted);">Belum ada portofolio untuk ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .project-item {
        transition: all 0.4s ease-in-out;
    }
    .project-item.hide {
        transform: scale(0.8);
        opacity: 0;
        display: none;
    }
    .filter-btn {
        transition: all 0.3s;
        cursor: pointer;
    }
    .filter-btn.active {
        background: #0d9488 !important;
        color: #fff !important;
        border-color: #0d9488 !important;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }
    .filter-btn:not(.active):hover {
        background: #f0fdfa;
        border-color: #0d9488;
    }
</style>

<script>
    function filterProjects(tag) {
        const container = document.getElementById('project-container');
        const items = container.getElementsByClassName('project-item');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Update active button
        buttons.forEach(btn => {
            btn.classList.remove('active');
            btn.classList.add('btn-outline');
            if(btn.innerText.toLowerCase().includes(tag.toLowerCase()) || (tag === 'all' && btn.innerText.toLowerCase().includes('all'))) {
                btn.classList.add('active');
                btn.classList.remove('btn-outline');
            }
        });

        // Filter items
        Array.from(items).forEach(item => {
            const itemTags = item.getAttribute('data-tags').toLowerCase();
            if (tag === 'all' || itemTags.includes(tag.toLowerCase())) {
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 10);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 400);
            }
        });
    }
</script>

<!-- Stats Section -->
<div class="container">
    <section class="stats-section">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); text-align: center; gap: 40px;">
            <div class="stat-item">
                <h2>120+</h2>
                <p>Projects Done</p>
            </div>
            <div class="stat-item">
                <h2>85+</h2>
                <p>Happy Clients</p>
            </div>
            <div class="stat-item">
                <h2>15+</h2>
                <p>Creative Awards</p>
            </div>
            <div class="stat-item">
                <h2>10+</h2>
                <p>Years in Industry</p>
            </div>
        </div>
    </section>
</div>

<!-- FAQ & Contact CTA -->
<section class="section-padding" id="faq">
    <div class="container">
        <div class="hero-grid">
            <div>
                <h2 style="font-size: 40px; margin-bottom: 40px;">Common Questions</h2>
                @forelse($faqs as $f)
                <div class="faq-item">
                    <div class="faq-q"><span>{{ $f->pertanyaan }}</span> <i class="fas fa-plus"></i></div>
                    <div class="faq-a">
                        <p>{{ $f->jawaban }}</p>
                    </div>
                </div>
                @empty
                <div class="faq-item">
                    <div class="faq-q"><span>Belum ada pertanyaan.</span> <i class="fas fa-plus"></i></div>
                </div>
                @endforelse
            </div>
            <div style="background: var(--purple); padding: 50px; border-radius: 40px; color: #fff; text-align: center;">
                <h2 style="color: #fff; margin-bottom: 20px;">Now Your Turn</h2>
                <p style="opacity: 0.8; margin-bottom: 35px;">Ready to start your next big project with us? Get in touch today for a free consultation.</p>
                <a href="/kontak" class="btn-cmn" style="width: 100%;">Get Started Now <i class="fas fa-rocket" style="margin-left: 10px;"></i></a>
            </div>
        </div>
    </div>
</section>

@endsection
