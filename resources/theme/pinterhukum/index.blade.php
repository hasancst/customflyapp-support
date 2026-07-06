@extends('tema::layout')

@section('title', 'Pusat Edukasi Hukum Terpercaya')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Reset & Utility */
    .hero-section {
        padding: 20px 0;
        margin-bottom: 40px;
        position: relative;
        clear: both;
    }

    /* 3-Column Grid Layout for Exactly 5 Features */
    .hero-container {
        display: grid;
        grid-template-columns: 2.5fr 1fr 1fr;
        gap: 15px;
        min-height: 240px; 
    }

    .hero-main {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
    }

    .hero-column {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 12px;
        height: 100%;
    }

    .hero-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        display: block;
    }

    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s;
    }

    .hero-item:hover .hero-img, .hero-main:hover .hero-img {
        transform: scale(1.05);
    }

    .hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 10px 15px;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%);
        color: #fff;
        z-index: 2;
    }

    .hero-main .hero-title {
        font-size: 1.1rem;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }

    .hero-item .hero-title {
        font-size: 0.7rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .hero-tag {
        background: var(--accent);
        color: #000;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 3px;
        display: inline-block;
        margin-bottom: 5px;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .hero-container { grid-template-columns: 1fr 1fr; height: auto; }
        .hero-main { grid-column: span 2; height: 180px; }
        .hero-column { height: 120px; gap: 8px; }
    }

    @media (max-width: 600px) {
        .hero-container { grid-template-columns: 1fr; }
        .hero-main { grid-column: span 1; height: 160px; }
        .hero-column { height: auto; }
        .hero-item { height: 100px; }
    }
</style>
@endsection

@section('konten')

@if($beritaTerbaru->onFirstPage())
<!-- Featured Section (1 Main + 2 Side Columns = 5 Total) -->
<section class="hero-section">
    <div class="container">
        <div class="hero-container">
            <!-- Box 1: Main Hero -->
            @if(isset($unggulan[0]))
            <div class="hero-main">
                <a href="/berita/{{ $unggulan[0]->kategoris->first()->slug ?? 'umum' }}/{{ $unggulan[0]->slug }}">
                    @php
                        $imgMain = $unggulan[0]->gambar_utama;
                        if ($imgMain && !str_starts_with($imgMain, 'http')) { $imgMain = '/storage/' . $imgMain; }
                        if (!$imgMain) { $imgMain = 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80'; }
                    @endphp
                    <img src="{{ $imgMain }}" class="hero-img" alt="{{ $unggulan[0]->judul }}">
                    <div class="hero-overlay">
                        <span class="hero-tag">{{ $unggulan[0]->kategoris->first()->nama ?? 'BERITA' }}</span>
                        <h2 class="hero-title">{{ $unggulan[0]->judul }}</h2>
                    </div>
                </a>
            </div>
            @endif

            <!-- Side Column 1 (Boxes 2 & 3) -->
            <div class="hero-column">
                @php $side1 = $unggulan->skip(1)->take(2); @endphp
                @foreach($side1 as $u)
                <div class="hero-item">
                    <a href="/berita/{{ $u->kategoris->first()->slug ?? 'umum' }}/{{ $u->slug }}">
                        @php
                            $imgS = $u->gambar_utama;
                            if ($imgS && !str_starts_with($imgS, 'http')) { $imgS = '/storage/' . $imgS; }
                            if (!$imgS) { $imgS = 'https://images.unsplash.com/photo-1505664194779-8beaceb93744?auto=format&fit=crop&w=800&q=80'; }
                        @endphp
                        <img src="{{ $imgS }}" class="hero-img" alt="{{ $u->judul }}">
                        <div class="hero-overlay">
                            <h3 class="hero-title">{{ str($u->judul)->limit(45) }}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Side Column 2 (Boxes 4 & 5) -->
            <div class="hero-column">
                @php $side2 = $unggulan->skip(3)->take(2); @endphp
                @foreach($side2 as $u)
                <div class="hero-item">
                    <a href="/berita/{{ $u->kategoris->first()->slug ?? 'umum' }}/{{ $u->slug }}">
                        @php
                            $imgS2 = $u->gambar_utama;
                            if ($imgS2 && !str_starts_with($imgS2, 'http')) { $imgS2 = '/storage/' . $imgS2; }
                            if (!$imgS2) { $imgS2 = 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80'; }
                        @endphp
                        <img src="{{ $imgS2 }}" class="hero-img" alt="{{ $u->judul }}">
                        <div class="hero-overlay">
                            <h3 class="hero-title">{{ str($u->judul)->limit(45) }}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Latest News Slider -->
<section class="slider-section" style="margin-bottom: 50px; position: relative; clear: both;">
    <div class="container">
        <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--primary); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <span style="width: 4px; height: 16px; background: var(--accent); border-radius: 2px;"></span>
            TERPOPULER BULAN INI
        </h3>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($beritaPopulerBulanIni as $bs)
                    <div class="swiper-slide">
                        <div style="background: #fff; border: 1px solid #eee; border-radius: 10px; overflow: hidden; height: 100%;">
                            <a href="/berita/{{ $bs->kategoris->first()->slug ?? 'umum' }}/{{ $bs->slug }}">
                                @php
                                    $imgSlid = $bs->gambar_utama;
                                    if ($imgSlid && !str_starts_with($imgSlid, 'http')) { $imgSlid = '/storage/' . $imgSlid; }
                                    if (!$imgSlid) { $imgSlid = 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80'; }
                                @endphp
                                <img src="{{ $imgSlid }}" style="height: 120px; width: 100%; object-fit: cover;" alt="{{ $bs->judul }}">
                                <div style="padding: 10px;">
                                    <h4 style="font-size: 0.8rem; font-weight: 700; color: #333; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
                                        {{ $bs->judul }}
                                    </h4>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
@endif

<!-- Section 3: Main Feed -->
<section class="main-feed-section">
    <div class="container">
        <div class="main-content">
            <main>
                <h2 class="section-title">Berita Terbaru</h2>
                @forelse($beritaTerbaru as $b)
                    <article class="post-card">
                        <a href="/berita/{{ $b->kategoris->first()->slug ?? 'umum' }}/{{ $b->slug }}" style="flex-shrink: 0;">
                            @php
                                $imgL = $b->gambar_utama;
                                if ($imgL && !str_starts_with($imgL, 'http')) { $imgL = '/storage/' . $imgL; }
                                if (!$imgL) { $imgL = 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80'; }
                            @endphp
                            <img src="{{ $imgL }}" alt="{{ $b->judul }}">
                        </a>
                        <div class="post-info">
                            <div class="post-date">
                                <span style="color: var(--primary); font-weight: 800;">{{ $b->kategoris->first()->nama ?? 'UMUM' }}</span>
                                &bull; {{ $b->created_at->format('d M Y') }}
                            </div>
                            <h3 class="post-title"><a href="/berita/{{ $b->kategoris->first()->slug ?? 'umum' }}/{{ $b->slug }}">{{ $b->judul }}</a></h3>
                            <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">{{ str($b->ringkasan)->limit(100) }}</p>
                        </div>
                    </article>
                @empty
                    <p>Belum ada berita.</p>
                @endforelse
                <div style="margin-top: 30px;">
                    {{ $beritaTerbaru->links('vendor.pagination.theme') }}
                </div>
            </main>
            <aside>
                @if(isset($globalIklan['sidebar_top']))
                    @foreach($globalIklan['sidebar_top'] as $iklan)
                        <div class="widget" style="padding: 0; overflow: hidden; background: transparent; box-shadow: none; margin-bottom: 25px;">
                            @if($iklan->jenis == 'gambar')
                                <a href="{{ $iklan->link }}" target="_blank">
                                    <img src="/storage/{{ $iklan->konten }}" style="width: 100%; border-radius: 12px; display: block; box-shadow: var(--shadow);">
                                </a>
                            @else
                                <div style="display: flex; justify-content: center;">
                                    {!! $iklan->konten !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

                <div class="widget">
                    <h4 class="widget-title">BERITA POPULER</h4>
                    <ul style="list-style: none; padding: 0;">
                        @foreach($beritaPopuler as $bp)
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;">
                            <span style="font-weight: 900; color: #ddd; font-size: 1.2rem;">{{ $loop->iteration }}</span>
                            <a href="/berita/{{ $bp->kategoris->first()->slug ?? 'umum' }}/{{ $bp->slug }}" style="font-size: 0.85rem; font-weight: 700; line-height: 1.3;">{{ $bp->judul }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                @if(isset($videoTerbaru) && $videoTerbaru->count() > 0)
                <div class="widget">
                    <h4 class="widget-title">VIDEO TERBARU</h4>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach($videoTerbaru as $vid)
                            @php
                                $videoId = '';
                                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vid->url, $match)) {
                                    $videoId = $match[1];
                                }
                            @endphp
                            <div style="border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                @if($videoId)
                                    <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                                                frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div style="padding: 15px; background: #f1f5f9; text-align: center;">
                                        <i class="fas fa-video" style="font-size: 2rem; color: #cbd5e1;"></i>
                                    </div>
                                @endif
                                <div style="padding: 12px;">
                                    <h5 style="font-size: 0.9rem; font-weight: 700; line-height: 1.4; margin: 0;">
                                        <a href="/video/{{ $vid->slug ?? '#' }}" style="text-decoration: none; color: inherit;">{{ $vid->judul }}</a>
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($globalIklan['sidebar_bottom']))
                    @foreach($globalIklan['sidebar_bottom'] as $iklan)
                        <div class="widget" style="padding: 0; overflow: hidden; background: transparent; box-shadow: none; margin-top: 25px;">
                            @if($iklan->jenis == 'gambar')
                                <a href="{{ $iklan->link }}" target="_blank">
                                    <img src="/storage/{{ $iklan->konten }}" style="width: 100%; border-radius: 12px; display: block; box-shadow: var(--shadow);">
                                </a>
                            @else
                                <div style="display: flex; justify-content: center;">
                                    {!! $iklan->konten !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </aside>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 5000 },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 }
            }
        });
    });
</script>
@endsection
