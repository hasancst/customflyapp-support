@extends('tema::layout')

@section('title', $berita->judul . ' | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <div class="blog-meta" style="margin-bottom: 1rem; color: var(--secondary); font-weight: 600;">
            {{ $berita->created_at->format('F d, Y') }} • @foreach($berita->kategoris as $k) {{ $k->judul }} @endforeach
        </div>
        <h1 class="section-title" style="max-width: 900px; margin: 0 auto;">{{ $berita->judul }}</h1>
    </div>
</section>

<section class="blog-detail" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="blog-featured-image reveal" style="margin-bottom: 4rem; border-radius: 30px; overflow: hidden; border: 1px solid var(--glass-border);">
            <img src="/storage/{{ $berita->gambar }}" alt="{{ $berita->judul }}" style="width: 100%; display: block;">
        </div>

        <div class="blog-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem;">
            <div class="blog-content-main reveal">
                <div class="article-body">
                    {!! $berita->isi !!}
                </div>
            </div>

            <div class="blog-sidebar">
                <div class="sidebar-widget reveal delay-1" style="margin-bottom: 3rem;">
                    <h4 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Popular Articles</h4>
                    <div class="popular-posts" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @foreach($topBerita as $top)
                            <div class="popular-item" style="display: flex; gap: 1rem; align-items: center;">
                                <div style="width: 80px; height: 80px; flex-shrink: 0; border-radius: 12px; overflow: hidden; border: 1px solid var(--glass-border);">
                                    <img src="/storage/{{ $top->gambar }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h5 style="font-size: 0.95rem; line-height: 1.4; margin-bottom: 0.3rem;"><a href="/berita/{{ $top->slug }}">{{ $top->judul }}</a></h5>
                                    <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $top->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-widget reveal delay-2">
                    <div class="glass-card" style="padding: 2rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; text-align: center;">
                        <h4 style="color: white; margin-bottom: 1rem;">Ready to start?</h4>
                        <p style="color: white; font-size: 0.9rem; margin-bottom: 1.5rem;">Let us help you bring your next innovation to life.</p>
                        <a href="/kontak" class="btn-secondary" style="background: white; color: var(--primary);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .article-body h2 { margin: 2rem 0 1rem; color: var(--primary); }
    .article-body p { margin-bottom: 1.5rem; color: var(--text-main); font-size: 1.1rem; line-height: 1.8; }
    .article-body img { max-width: 100%; border-radius: 16px; margin: 2rem 0; }
    
    @media (max-width: 1024px) {
        .blog-layout { grid-template-columns: 1fr; }
    }
</style>
@endsection
