@extends('tema::layout')

@section('title', $pengaturan['nama_situs'] ?? 'iMakeCustom | Premium Bespoke Solutions')

@section('styles')
<style>
    .avea-slider-section {
        padding: 7.5rem 0 4.5rem;
        position: relative;
        overflow: hidden;
    }
    .avea-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .avea-header p {
        color: var(--text-muted, #94a3b8);
        margin: 0.5rem auto 0;
        max-width: 560px;
    }
    .avea-controls {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .avea-ctrl-btn {
        width: 42px;
        height: 42px;
        border-radius: 999px;
        border: 1px solid var(--glass-border, rgba(255,255,255,0.14));
        background: rgba(255,255,255,0.04);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .avea-ctrl-btn:hover {
        background: var(--primary, #38bdf8);
        color: #0b0f19;
        border-color: var(--primary, #38bdf8);
    }
    .avea-stage {
        position: relative;
        height: 500px;
        perspective: 1600px;
        transform-style: preserve-3d;
        user-select: none;
        touch-action: pan-y;
    }
    .avea-track {
        position: relative;
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
    }
    .avea-card {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 580px;
        height: 420px;
        margin-top: -210px;
        margin-left: -290px;
        border-radius: 18px;
        background: #05070d;
        padding: 18px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
        transition: transform 0.75s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.6s ease, box-shadow 0.4s ease, border-color 0.4s ease;
        cursor: pointer;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        backface-visibility: hidden;
    }
    .avea-card.is-active {
        border-color: rgba(56, 189, 248, 0.55);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.78), 0 0 32px rgba(56, 189, 248, 0.16);
    }
    .avea-card-media {
        position: relative;
        flex: 1;
        min-height: 0;
        border-radius: 10px;
        overflow: hidden;
        background: #0f172a;
    }
    .avea-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        display: block;
        transition: transform 0.5s ease;
    }
    .avea-card.is-active:hover .avea-card-media img {
        transform: scale(1.04);
    }
    .avea-card-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(11, 15, 25, 0.82);
        backdrop-filter: blur(8px);
        color: #38bdf8;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid rgba(56, 189, 248, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .avea-open-pill {
        position: absolute;
        right: 10px;
        bottom: 10px;
        background: rgba(56, 189, 248, 0.95);
        color: #0b0f19;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 5px 11px;
        border-radius: 999px;
        opacity: 0;
        transform: translateY(6px);
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .avea-card.is-active:hover .avea-open-pill {
        opacity: 1;
        transform: translateY(0);
    }
    .avea-card-meta {
        padding-top: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .avea-card-title {
        color: #f8fafc;
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .avea-card-index {
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 600;
        flex-shrink: 0;
    }
    .avea-dots {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    .avea-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.22);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .avea-dot.is-active {
        width: 28px;
        background: var(--primary, #38bdf8);
    }
    .avea-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(5, 8, 17, 0.86);
        backdrop-filter: blur(10px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .avea-modal.is-open {
        display: flex;
    }
    .avea-modal-dialog {
        width: 100%;
        max-width: 780px;
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 30px 90px rgba(0, 0, 0, 0.75);
        position: relative;
    }
    .avea-modal-close {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 2;
        width: 38px;
        height: 38px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,0.2);
        background: rgba(11,15,25,0.75);
        color: #fff;
        cursor: pointer;
        font-size: 1rem;
    }
    .avea-modal-img {
        width: 100%;
        max-height: 440px;
        object-fit: cover;
        display: block;
        background: #05070d;
    }
    .avea-modal-body {
        padding: 1.5rem 1.75rem;
    }
    .avea-modal-body h3 {
        margin: 0.4rem 0 0.5rem;
        color: #fff;
        font-size: 1.35rem;
    }
    .avea-modal-body p {
        color: #94a3b8;
        margin-bottom: 1.25rem;
        line-height: 1.6;
    }
    .avea-modal-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    @media (max-width: 1024px) {
        .avea-stage {
            height: 410px;
        }
        .avea-card {
            width: 440px;
            height: 330px;
            margin-top: -165px;
            margin-left: -220px;
            padding: 14px;
        }
    }
    @media (max-width: 767px) {
        .avea-stage {
            height: 320px;
        }
        .avea-card {
            width: 300px;
            height: 250px;
            margin-top: -125px;
            margin-left: -150px;
            padding: 12px;
        }
    }

    /* ─── Complete 3-Suite Platform Section ─── */
    .suite-platform-section {
        padding: 5.5rem 0;
        position: relative;
    }
    .suite-header {
        text-align: center;
        margin-bottom: 3.75rem;
    }
    .suite-eyebrow {
        display: inline-block;
        color: #38bdf8;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        margin-bottom: 0.65rem;
    }
    .suite-main-title {
        font-size: clamp(1.65rem, 3.2vw, 2.4rem);
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.025em;
        line-height: 1.25;
        margin: 0;
    }
    .suite-rows {
        display: flex;
        flex-direction: column;
        gap: 4.5rem;
    }
    .suite-row {
        display: grid;
        grid-template-columns: 1fr 1.08fr;
        gap: 3.5rem;
        align-items: center;
    }
    .suite-row.is-reversed .suite-text-col {
        order: 2;
    }
    .suite-row.is-reversed .suite-image-col {
        order: 1;
    }
    .suite-row-eyebrow {
        display: inline-block;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }
    .suite-row-title {
        font-size: clamp(1.45rem, 2.4vw, 2rem);
        font-weight: 800;
        color: #ffffff;
        line-height: 1.25;
        margin: 0 0 1rem;
    }
    .suite-row-desc {
        color: var(--text-muted, #94a3b8);
        font-size: 0.98rem;
        line-height: 1.7;
        margin: 0 0 1.35rem;
    }
    .suite-chips {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
        margin-bottom: 1.85rem;
    }
    .suite-chip {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: #e2e8f0;
        font-size: 0.94rem;
        font-weight: 500;
    }
    .suite-chip svg {
        flex-shrink: 0;
    }
    .suite-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.85rem 1.7rem;
        border-radius: 999px;
        color: #ffffff;
        font-size: 0.84rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .suite-cta-btn:hover {
        transform: translateY(-2px);
    }
    .suite-image-frame {
        border-radius: 20px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 12px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
        transition: transform 0.35s ease, border-color 0.35s ease;
    }
    .suite-image-frame:hover {
        transform: translateY(-4px);
        border-color: rgba(56, 189, 248, 0.35);
    }
    .suite-image-frame img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        display: block;
    }
    @media (max-width: 991px) {
        .suite-row {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .suite-row.is-reversed .suite-text-col,
        .suite-row.is-reversed .suite-image-col {
            order: initial;
        }
    }
    .portfolio-gallery-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        background: rgba(11, 15, 25, 0.8);
        backdrop-filter: blur(8px);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.16);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .pf-thumbs {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
        padding: 12px 1.75rem 0;
    }
    .pf-thumb {
        height: 58px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.2s ease;
        background: #05070d;
        padding: 0;
    }
    .pf-thumb.is-active,
    .pf-thumb:hover {
        opacity: 1;
        border-color: #38bdf8;
    }
    .pf-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .portfolio-card-5 {
        height: auto !important;
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .portfolio-card-5:hover {
        transform: translateY(-4px);
        border-color: rgba(56, 189, 248, 0.4);
    }
    .pf-card-main {
        position: relative;
        height: 230px;
        background: #05070d;
        overflow: hidden;
    }
    .pf-card-main img.pf-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        display: block;
        transition: transform 0.35s ease;
    }
    .portfolio-card-5:hover .pf-card-main img.pf-main-img {
        transform: scale(1.03);
    }
    .pf-card-thumbs {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 6px;
        padding: 10px 12px 0;
        background: rgba(15, 23, 42, 0.9);
    }
    .pf-card-thumb {
        height: 46px;
        border-radius: 6px;
        overflow: hidden;
        border: 2px solid transparent;
        padding: 0;
        background: #05070d;
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.2s ease;
    }
    .pf-card-thumb.is-active,
    .pf-card-thumb:hover {
        opacity: 1;
        border-color: #38bdf8;
    }
    .pf-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .pf-card-info {
        padding: 12px 14px 16px;
    }
    .pf-card-cat {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #38bdf8;
        margin-bottom: 4px;
    }
    .pf-card-info h4 {
        color: #fff;
        font-size: 1.08rem;
        font-weight: 700;
        margin: 0 0 6px;
    }
    .pf-card-info p {
        color: #94a3b8;
        font-size: 0.86rem;
        line-height: 1.5;
        margin: 0;
    }
    #portfolio .portfolio-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.75rem;
    }
    @media (max-width: 991px) {
        #portfolio .portfolio-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        #portfolio .portfolio-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('konten')
    {{-- Hidden hero section
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
    --}}

    @php
        $sliderTitle = $pengaturan['slider_3d_judul'] ?? 'Interactive <span>3D Showcase</span>';
        $sliderDesc = $pengaturan['slider_3d_deskripsi'] ?? 'Click any side card to bring it forward, or click the center card to open and explore.';
        $sliderSource = $pengaturan['slider_3d_sumber'] ?? 'gabungan';

        $aveaItems = collect();
        if (isset($slideshow)) {
            foreach ($slideshow as $s) {
                if (!empty($s->gambar)) {
                    $aveaItems->push([
                        'judul' => strip_tags($s->judul),
                        'deskripsi' => $s->deskripsi ?? '',
                        'kategori' => $s->badge_1 ?? 'Featured',
                        'gambar' => (str_starts_with($s->gambar, 'http') ? $s->gambar : '/storage/' . ltrim($s->gambar, '/')),
                        'url' => $s->url ?? '#contact',
                    ]);
                }
            }
        }
        if ($sliderSource !== 'slideshow') {
            if (isset($portofolios)) {
                foreach ($portofolios as $p) {
                    if (!empty($p->gambar)) {
                        $aveaItems->push([
                            'judul' => $p->judul,
                            'deskripsi' => $p->deskripsi ?? '',
                            'kategori' => $p->kategori ?? 'Showcase',
                            'gambar' => '/storage/' . ltrim($p->gambar, '/'),
                            'url' => '#portfolio',
                        ]);
                    }
                }
            }
            if ($aveaItems->count() < 7 && isset($unggulan)) {
                foreach ($unggulan as $u) {
                    $img = $u->gambar_utama ?? $u->gambar;
                    if (!empty($img)) {
                        $aveaItems->push([
                            'judul' => $u->judul,
                            'deskripsi' => \Illuminate\Support\Str::limit(strip_tags($u->ringkasan ?: $u->isi), 120),
                            'kategori' => $u->kategoris->first()->nama ?? 'Insight',
                            'gambar' => (str_starts_with($img, 'http') ? $img : '/storage/' . ltrim($img, '/')) . '?v=' . ($u->updated_at?->timestamp ?? 1),
                            'url' => '/blog/' . $u->slug,
                        ]);
                    }
                }
            }
        }
    @endphp

    @if($aveaItems->isNotEmpty())
    <section id="avea-showcase" class="avea-slider-section">
        <div class="container">
            <div class="avea-header reveal">
                <h2 class="section-title" style="margin-bottom: 0;">{!! $sliderTitle !!}</h2>
                @if($sliderDesc !== '')
                <p>{{ $sliderDesc }}</p>
                @endif
                {{--
                <div class="avea-controls">
                    <button type="button" class="avea-ctrl-btn" id="aveaPrev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" class="avea-ctrl-btn" id="aveaPlayToggle" aria-label="Pause auto rotation" title="Pause / Play"><i class="fas fa-pause"></i></button>
                    <button type="button" class="avea-ctrl-btn" id="aveaNext" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
                </div>
                --}}
            </div>

            <div class="avea-stage" id="aveaStage">
                <div class="avea-track" id="aveaTrack">
                    @foreach($aveaItems as $idx => $item)
                    <div class="avea-card"
                         data-index="{{ $idx }}"
                         data-title="{{ $item['judul'] }}"
                         data-desc="{{ $item['deskripsi'] }}"
                         data-cat="{{ $item['kategori'] }}"
                         data-img="{{ $item['gambar'] }}"
                         data-url="{{ $item['url'] }}">
                        <div class="avea-card-media">
                            <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}" loading="lazy">
                            <span class="avea-card-badge">{{ $item['kategori'] }}</span>
                            <span class="avea-open-pill"><i class="fas fa-expand"></i> Open</span>
                        </div>
                        <div class="avea-card-meta">
                            <h3 class="avea-card-title">{{ $item['judul'] }}</h3>
                            <span class="avea-card-index">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="avea-dots" id="aveaDots">
                @foreach($aveaItems as $idx => $item)
                <button type="button" class="avea-dot" data-index="{{ $idx }}" aria-label="Select slide {{ $idx + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </section>

    <div class="avea-modal" id="aveaModal" aria-hidden="true">
        <div class="avea-modal-dialog">
            <button type="button" class="avea-modal-close" id="aveaModalClose" aria-label="Close preview"><i class="fas fa-times"></i></button>
            <img src="" alt="" class="avea-modal-img" id="aveaModalImg">
            <div class="avea-modal-body">
                <span class="avea-card-badge" style="position: static; display: inline-block; margin-bottom: 0.4rem;" id="aveaModalCat"></span>
                <h3 id="aveaModalTitle"></h3>
                <p id="aveaModalDesc"></p>
                <div class="avea-modal-actions">
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="avea-ctrl-btn" id="aveaModalPrev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
                        <button type="button" class="avea-ctrl-btn" id="aveaModalNext" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <a href="#" class="btn-primary" id="aveaModalLink">Open Details <i class="fas fa-arrow-right" style="margin-left: 6px;"></i></a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @php
        $suiteEyebrow = $pengaturan['suite_eyebrow'] ?? 'COMPLETE 3-SUITE PLATFORM';
        $suiteTitle = $pengaturan['suite_title'] ?? 'Customfly • Uploadfly • Optionfly — Complete Personalization Suite';
        $decodedSuites = !empty($pengaturan['suite_items_json']) ? json_decode($pengaturan['suite_items_json'], true) : null;
        $suites = (is_array($decodedSuites) && count($decodedSuites) > 0)
            ? $decodedSuites
            : \App\Modul\Layanan\Http\Controllers\LayananController::defaultSuites();
    @endphp

    <section id="features" class="suite-platform-section">
        <div class="container">
            <div class="suite-header reveal">
                <span class="suite-eyebrow">{{ $suiteEyebrow }}</span>
                <h2 class="suite-main-title">{{ $suiteTitle }}</h2>
            </div>

            <div class="suite-rows">
                @foreach($suites as $suite)
                <div class="suite-row {{ $suite['reversed'] ? 'is-reversed' : '' }} reveal">
                    <div class="suite-text-col">
                        <span class="suite-row-eyebrow" style="color: {{ $suite['color'] }};">{{ $suite['eyebrow'] }}</span>
                        <h3 class="suite-row-title">{{ $suite['title'] }}</h3>
                        <p class="suite-row-desc">{{ $suite['desc'] }}</p>
                        <div class="suite-chips">
                            @foreach($suite['chips'] as $chip)
                            <div class="suite-chip">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: {{ $suite['color'] }};"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>{{ $chip }}</span>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ $suite['url'] }}" @if(str_starts_with($suite['url'], 'http')) target="_blank" rel="noopener" @endif class="suite-cta-btn" style="background: {{ $suite['btn_bg'] }}; box-shadow: {{ $suite['btn_shadow'] }};">
                            <span>{{ $suite['cta'] }}</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                    <div class="suite-image-col">
                        <div class="suite-image-frame">
                            <img src="{{ $suite['image'] }}" alt="{{ $suite['title'] }}" loading="lazy">
                        </div>
                    </div>
                </div>
                @endforeach
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
        <div class="container">
            <div class="portfolio-grid">
            @if(isset($portofolios) && count($portofolios) > 0)
                @foreach($portofolios as $p)
                    @include('tema::partials.portfolio_card', ['p' => $p])
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

    (function initAveaSlider() {
        const stage = document.getElementById('aveaStage');
        const cards = Array.from(document.querySelectorAll('#aveaTrack .avea-card'));
        const dots = Array.from(document.querySelectorAll('#aveaDots .avea-dot'));
        if (!stage || cards.length === 0) return;

        const prevBtn = document.getElementById('aveaPrev');
        const nextBtn = document.getElementById('aveaNext');
        const playBtn = document.getElementById('aveaPlayToggle');

        const modal = document.getElementById('aveaModal');
        const modalImg = document.getElementById('aveaModalImg');
        const modalCat = document.getElementById('aveaModalCat');
        const modalTitle = document.getElementById('aveaModalTitle');
        const modalDesc = document.getElementById('aveaModalDesc');
        const modalLink = document.getElementById('aveaModalLink');
        const modalClose = document.getElementById('aveaModalClose');
        const modalPrev = document.getElementById('aveaModalPrev');
        const modalNext = document.getElementById('aveaModalNext');

        const total = cards.length;
        let active = 0;
        let isPlaying = true;
        let isHovering = false;
        let timer = null;

        function getCircularOffset(index) {
            let diff = index - active;
            if (diff > total / 2) diff -= total;
            if (diff < -total / 2) diff += total;
            return diff;
        }

        function render() {
            const w = window.innerWidth;
            const isMobile = w < 768;
            const isTablet = w >= 768 && w <= 1024;
            const stepX = isMobile ? 160 : (isTablet ? 275 : 365);

            cards.forEach((card, idx) => {
                const offset = getCircularOffset(idx);
                const abs = Math.abs(offset);

                card.classList.toggle('is-active', offset === 0);

                if (abs > 3) {
                    card.style.opacity = '0';
                    card.style.pointerEvents = 'none';
                    card.style.zIndex = '0';
                    card.style.transform = `translate3d(${offset * stepX}px, 0, -420px) rotateY(${offset > 0 ? -65 : 65}deg) scale(0.45)`;
                    return;
                }

                const translateX = offset * stepX;
                const translateZ = offset === 0 ? 110 : -Math.pow(abs, 1.35) * 105;
                const rotateY = offset === 0 ? 0 : (offset > 0 ? -Math.min(58, 26 * abs) : Math.min(58, 26 * abs));
                const scale = offset === 0 ? 1 : Math.max(0.55, 1 - abs * 0.16);
                const opacity = offset === 0 ? 1 : Math.max(0.42, 1 - abs * 0.22);

                card.style.opacity = String(opacity);
                card.style.pointerEvents = 'auto';
                card.style.zIndex = String(20 - abs);
                card.style.transform = `translate3d(${translateX}px, 0, ${translateZ}px) rotateY(${rotateY}deg) scale(${scale})`;
            });

            dots.forEach((dot, idx) => {
                dot.classList.toggle('is-active', idx === active);
            });
        }

        function goTo(index) {
            active = ((index % total) + total) % total;
            render();
        }

        function openModal(idx) {
            const card = cards[idx];
            if (!card) return;
            modal.dataset.mode = 'avea';
            const tb = document.getElementById('pfThumbsBar');
            if (tb) tb.style.display = 'none';
            modalImg.src = card.dataset.img || '';
            modalImg.alt = card.dataset.title || '';
            modalCat.textContent = card.dataset.cat || 'Showcase';
            modalTitle.textContent = card.dataset.title || '';
            modalDesc.textContent = card.dataset.desc || '';

            const url = card.dataset.url || '#';
            if (url && url !== '#') {
                modalLink.href = url;
                modalLink.style.display = 'inline-flex';
            } else {
                modalLink.style.display = 'none';
            }

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        }

        function startAuto() {
            stopAuto();
            if (!isPlaying) return;
            timer = setInterval(() => {
                if (!isHovering && !modal.classList.contains('is-open')) {
                    goTo(active + 1);
                }
            }, 3200);
        }

        function stopAuto() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        cards.forEach((card, idx) => {
            card.addEventListener('click', () => {
                if (idx === active) {
                    openModal(idx);
                } else {
                    goTo(idx);
                    startAuto();
                }
            });
        });

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                goTo(idx);
                startAuto();
            });
        });

        if (prevBtn) prevBtn.addEventListener('click', () => { goTo(active - 1); startAuto(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { goTo(active + 1); startAuto(); });
        if (playBtn) {
            playBtn.addEventListener('click', () => {
                isPlaying = !isPlaying;
                playBtn.innerHTML = isPlaying ? '<i class="fas fa-pause"></i>' : '<i class="fas fa-play"></i>';
                if (isPlaying) startAuto();
                else stopAuto();
            });
        }

        if (modalClose) modalClose.addEventListener('click', closeModal);
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        }
        if (modalPrev) modalPrev.addEventListener('click', () => {
            if (modal.dataset.mode === 'portfolio') return;
            goTo(active - 1);
            openModal(active);
        });
        if (modalNext) modalNext.addEventListener('click', () => {
            if (modal.dataset.mode === 'portfolio') return;
            goTo(active + 1);
            openModal(active);
        });

        stage.addEventListener('mouseenter', () => { isHovering = true; });
        stage.addEventListener('mouseleave', () => { isHovering = false; });

        let pointerStartX = null;
        stage.addEventListener('pointerdown', (e) => { pointerStartX = e.clientX; });
        stage.addEventListener('pointerup', (e) => {
            if (pointerStartX === null) return;
            const dx = e.clientX - pointerStartX;
            pointerStartX = null;
            if (Math.abs(dx) > 45) {
                goTo(dx < 0 ? active + 1 : active - 1);
                startAuto();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
        });

        window.addEventListener('resize', render);
        render();
        startAuto();
    })();

    (function initPortfolioGallery() {
        const items = document.querySelectorAll('.portfolio-item[data-images]');
        const modal = document.getElementById('aveaModal');
        const modalImg = document.getElementById('aveaModalImg');
        const modalCat = document.getElementById('aveaModalCat');
        const modalTitle = document.getElementById('aveaModalTitle');
        const modalDesc = document.getElementById('aveaModalDesc');
        const modalLink = document.getElementById('aveaModalLink');
        const modalPrev = document.getElementById('aveaModalPrev');
        const modalNext = document.getElementById('aveaModalNext');
        if (!items.length || !modal) return;

        let thumbBar = document.getElementById('pfThumbsBar');
        if (!thumbBar) {
            thumbBar = document.createElement('div');
            thumbBar.id = 'pfThumbsBar';
            thumbBar.className = 'pf-thumbs';
            thumbBar.style.display = 'none';
            modalImg.insertAdjacentElement('afterend', thumbBar);
        }

        let currentImages = [];
        let currentIdx = 0;

        function showSlide(i) {
            if (!currentImages.length) return;
            currentIdx = ((i % currentImages.length) + currentImages.length) % currentImages.length;
            modalImg.src = currentImages[currentIdx];
            thumbBar.querySelectorAll('.pf-thumb').forEach((btn, idx) => {
                btn.classList.toggle('is-active', idx === currentIdx);
            });
        }

        items.forEach(item => {
            const mainImg = item.querySelector('.pf-main-img');
            const cardThumbs = item.querySelectorAll('.pf-card-thumb');
            let activeCardIdx = 0;

            cardThumbs.forEach(tb => {
                tb.addEventListener('click', (ev) => {
                    ev.stopPropagation();
                    activeCardIdx = parseInt(tb.dataset.idx || '0', 10);
                    if (mainImg && tb.dataset.src) mainImg.src = tb.dataset.src;
                    cardThumbs.forEach(b => b.classList.remove('is-active'));
                    tb.classList.add('is-active');
                });
            });

            item.addEventListener('click', () => {
                try {
                    currentImages = JSON.parse(item.dataset.images || '[]');
                } catch (e) {
                    currentImages = [];
                }
                if (!currentImages.length) return;

                modalCat.textContent = item.dataset.cat || 'Showcase';
                modalTitle.textContent = item.dataset.title || '';
                modalDesc.textContent = item.dataset.desc || '';

                const url = item.dataset.url || '';
                if (url && url !== '#') {
                    modalLink.href = url;
                    modalLink.target = url.startsWith('http') ? '_blank' : '_self';
                    modalLink.style.display = 'inline-flex';
                } else {
                    modalLink.style.display = 'none';
                }

                thumbBar.innerHTML = '';
                if (currentImages.length > 1) {
                    thumbBar.style.display = 'grid';
                    currentImages.forEach((src, idx) => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'pf-thumb';
                        btn.innerHTML = `<img src="${src}" alt="">`;
                        btn.addEventListener('click', (ev) => {
                            ev.stopPropagation();
                            showSlide(idx);
                        });
                        thumbBar.appendChild(btn);
                    });
                } else {
                    thumbBar.style.display = 'none';
                }

                modal.dataset.mode = 'portfolio';
                showSlide(activeCardIdx);
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        modalPrev?.addEventListener('click', () => {
            if (modal.dataset.mode === 'portfolio' && currentImages.length > 1) showSlide(currentIdx - 1);
        });
        modalNext?.addEventListener('click', () => {
            if (modal.dataset.mode === 'portfolio' && currentImages.length > 1) showSlide(currentIdx + 1);
        });
    })();
</script>
@endsection
