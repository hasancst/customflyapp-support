@extends('tema::layout')

@section('title', $berita->judul . ' | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))
@section('description', $berita->ringkasan ?: Str::limit(strip_tags($berita->isi), 155))

@section('konten')
@php
    $wordCount = str_word_count(strip_tags($berita->isi ?? ''));
    $readMinutes = max(1, (int) ceil($wordCount / 200));
@endphp

<section class="blog-detail-section">
    <div class="container">
        {{-- Compact Breadcrumb & Header --}}
        <div class="blog-header-compact">
            <div class="blog-breadcrumb" role="navigation" aria-label="Breadcrumb">
                <a href="/"><i class="fas fa-home"></i> Home</a>
                <span class="crumb-sep"><i class="fas fa-chevron-right"></i></span>
                <a href="/blog">Blog</a>
                @if($berita->kategoris->isNotEmpty())
                    <span class="crumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <a href="/blog/kategori/{{ $berita->kategoris->first()->slug }}">{{ $berita->kategoris->first()->nama ?? $berita->kategoris->first()->judul }}</a>
                @endif
            </div>

            <div class="blog-meta-row">
                @foreach($berita->kategoris as $k)
                    <a href="/blog/kategori/{{ $k->slug }}" class="blog-badge">{{ $k->nama ?? $k->judul }}</a>
                @endforeach
                <span class="meta-item"><i class="far fa-calendar-alt"></i> {{ $berita->created_at->format('M d, Y') }}</span>
                <span class="meta-item"><i class="far fa-clock"></i> {{ $readMinutes }} min read</span>
                @if($berita->penulis)
                    <span class="meta-item"><i class="far fa-user"></i> {{ $berita->penulis->name ?? $berita->penulis->nama ?? 'Admin' }}</span>
                @endif
            </div>

            <h1 class="blog-detail-title">{{ $berita->judul }}</h1>
        </div>

        {{-- Main 2-Column Layout --}}
        <div class="blog-layout">
            <article class="blog-content-main">
                @if($berita->gambar_utama ?? $berita->gambar)
                <div class="blog-featured-image">
                    <img src="/storage/{{ $berita->gambar_utama ?? $berita->gambar }}?v={{ $berita->updated_at?->timestamp ?? 1 }}" alt="{{ $berita->judul }}">
                </div>
                @endif

                <div class="article-body">
                    {!! $berita->isi !!}
                </div>

                {{-- Tags & Share Bar --}}
                <div class="blog-footer-bar">
                    @if($berita->tags && $berita->tags->isNotEmpty())
                    <div class="blog-tags">
                        <span class="tags-label"><i class="fas fa-tags"></i> Tags:</span>
                        @foreach($berita->tags as $tag)
                            <a href="/tag/{{ $tag->slug }}" class="tag-pill">#{{ $tag->nama ?? $tag->slug }}</a>
                        @endforeach
                    </div>
                    @endif

                    <div class="blog-actions-row">
                        <a href="/blog" class="btn-back-blog">
                            <i class="fas fa-arrow-left"></i> Back to Blog
                        </a>
                        <div class="share-links">
                            <span class="share-label">Share:</span>
                            <button type="button" class="share-btn" onclick="copyBlogLink(this)" title="Copy link">
                                <i class="fas fa-link"></i>
                            </button>
                            <a class="share-btn" href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->judul) }}" target="_blank" rel="noopener" title="Share on X">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="share-btn" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Compact Sticky Sidebar --}}
            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h4 class="sidebar-title">Popular Articles</h4>
                    <div class="popular-posts">
                        @foreach($topBerita as $top)
                            <a href="/blog/{{ $top->slug }}" class="popular-item">
                                @if($top->gambar_utama ?? $top->gambar)
                                <div class="popular-thumb">
                                    <img src="/storage/{{ $top->gambar_utama ?? $top->gambar }}?v={{ $top->updated_at?->timestamp ?? 1 }}" alt="{{ $top->judul }}">
                                </div>
                                @endif
                                <div class="popular-info">
                                    <h5>{{ Str::limit($top->judul, 62) }}</h5>
                                    <span><i class="far fa-calendar-alt"></i> {{ $top->created_at->format('M d, Y') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-cta">
                    <div class="cta-icon"><i class="fas fa-rocket"></i></div>
                    <h4>Ready to start?</h4>
                    <p>Let us help you bring your next custom product innovation to life.</p>
                    <a href="/kontak" class="btn-cta-white">Contact Us <i class="fas fa-arrow-right"></i></a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .blog-detail-section {
        padding-top: 5.75rem;
        padding-bottom: 4rem;
    }

    .blog-header-compact {
        margin-bottom: 1.5rem;
    }

    .blog-breadcrumb {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.45rem;
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-bottom: 0.75rem;
    }
    .blog-breadcrumb .crumb-sep {
        font-size: 0.65rem;
        opacity: 0.55;
    }
    .blog-breadcrumb a {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .blog-breadcrumb a:hover {
        color: var(--secondary);
    }

    .blog-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.6rem 1rem;
        margin-bottom: 0.7rem;
        font-size: 0.84rem;
        color: var(--text-muted);
    }

    .blog-badge {
        display: inline-block;
        padding: 0.22rem 0.75rem;
        border-radius: 50px;
        background: rgba(99, 102, 241, 0.16);
        border: 1px solid rgba(99, 102, 241, 0.35);
        color: #a5b4fc;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .blog-badge:hover {
        background: var(--primary);
        color: #fff;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .blog-detail-title {
        font-size: clamp(1.45rem, 2.3vw, 2rem);
        font-weight: 800;
        line-height: 1.28;
        letter-spacing: -0.02em;
        color: var(--text-main);
        max-width: 920px;
    }

    .blog-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 2.5rem;
        align-items: start;
    }

    .blog-content-main {
        background: rgba(30, 41, 59, 0.45);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 1.75rem;
    }

    .blog-featured-image {
        margin-bottom: 1.75rem;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        background: rgba(15, 23, 42, 0.6);
        max-height: 340px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .blog-featured-image img {
        width: 100%;
        height: 100%;
        max-height: 340px;
        object-fit: cover;
        display: block;
    }

    /* Rich Article Typography */
    .article-body {
        color: #cbd5e1;
        font-size: 1.02rem;
        line-height: 1.78;
        word-wrap: break-word;
    }

    .article-body h1,
    .article-body h2,
    .article-body h3,
    .article-body h4 {
        color: var(--text-main);
        font-weight: 700;
        line-height: 1.35;
        margin: 1.65rem 0 0.75rem;
    }

    .article-body h1 { font-size: 1.45rem; }
    .article-body h2 { font-size: 1.35rem; color: #a5b4fc; }
    .article-body h3 { font-size: 1.15rem; color: var(--secondary); }

    .article-body p {
        margin-bottom: 1.15rem;
    }

    .article-body ul {
        list-style: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .article-body ol {
        list-style: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .article-body li {
        margin-bottom: 0.45rem;
    }

    .article-body a {
        color: var(--secondary);
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .article-body a:hover {
        color: #a5b4fc;
    }

    .article-body blockquote {
        border-left: 3px solid var(--primary);
        background: rgba(99, 102, 241, 0.08);
        padding: 0.9rem 1.25rem;
        border-radius: 0 10px 10px 0;
        margin: 1.25rem 0;
        color: #e2e8f0;
        font-style: italic;
    }

    .article-body code {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid var(--glass-border);
        padding: 0.15rem 0.4rem;
        border-radius: 6px;
        font-size: 0.9em;
        color: #67e8f9;
    }

    .article-body hr {
        border: none;
        border-top: 1px solid var(--glass-border);
        margin: 1.75rem 0;
    }

    .article-body img {
        max-width: 100%;
        max-height: 400px;
        width: auto;
        height: auto;
        border-radius: 12px;
        margin: 1.25rem 0;
        border: 1px solid var(--glass-border);
    }

    /* Footer Bar */
    .blog-footer-bar {
        margin-top: 2rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .blog-tags {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .tags-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-right: 0.25rem;
    }

    .tag-pill {
        font-size: 0.8rem;
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
    }
    .tag-pill:hover {
        border-color: var(--secondary);
        color: var(--secondary);
    }

    .blog-actions-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn-back-blog {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-main);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        background: var(--glass);
        border: 1px solid var(--glass-border);
    }
    .btn-back-blog:hover {
        border-color: var(--primary);
        color: #a5b4fc;
    }

    .share-links {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .share-label {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-right: 0.25rem;
    }

    .share-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid var(--glass-border);
        background: var(--glass);
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.85rem;
        transition: var(--transition);
    }
    .share-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    /* Sidebar */
    .blog-sidebar {
        position: sticky;
        top: 5.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-card {
        background: rgba(30, 41, 59, 0.45);
        border: 1px solid var(--glass-border);
        border-radius: 18px;
        padding: 1.35rem;
    }

    .sidebar-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 1.1rem;
        padding-bottom: 0.65rem;
        border-bottom: 1px solid var(--glass-border);
        color: var(--text-main);
    }

    .popular-posts {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .popular-item {
        display: flex;
        gap: 0.85rem;
        align-items: center;
        padding: 0.45rem;
        border-radius: 12px;
        transition: var(--transition);
    }
    .popular-item:hover {
        background: rgba(255, 255, 255, 0.04);
    }

    .popular-thumb {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        background: rgba(15, 23, 42, 0.6);
    }

    .popular-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .popular-info h5 {
        font-size: 0.88rem;
        font-weight: 600;
        line-height: 1.35;
        margin-bottom: 0.25rem;
        color: var(--text-main);
    }
    .popular-item:hover .popular-info h5 {
        color: var(--secondary);
    }

    .popular-info span {
        font-size: 0.76rem;
        color: var(--text-muted);
    }

    .sidebar-cta {
        padding: 1.5rem;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(6, 182, 212, 0.9));
        text-align: center;
        box-shadow: 0 12px 25px -8px rgba(99, 102, 241, 0.35);
    }

    .cta-icon {
        width: 42px;
        height: 42px;
        margin: 0 auto 0.75rem;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
    }

    .sidebar-cta h4 {
        color: #fff;
        font-size: 1.1rem;
        margin-bottom: 0.45rem;
    }

    .sidebar-cta p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        margin-bottom: 1.15rem;
        line-height: 1.5;
    }

    .btn-cta-white {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: #fff;
        color: var(--primary-hover);
        padding: 0.6rem 1.3rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
    }
    .btn-cta-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 992px) {
        .blog-layout {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .blog-sidebar {
            position: static;
        }
        .blog-content-main {
            padding: 1.25rem;
        }
        .blog-featured-image,
        .blog-featured-image img {
            max-height: 250px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function copyBlogLink(btn) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href).then(function() {
                var icon = btn.querySelector('i');
                icon.className = 'fas fa-check';
                setTimeout(function() {
                    icon.className = 'fas fa-link';
                }, 1800);
            });
        }
    }
</script>
@endsection
