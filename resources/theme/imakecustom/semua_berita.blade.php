@extends('tema::layout')

@section('title', 'Latest Insights | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('styles')
<style>
    .featured-blog-section {
        padding-top: 7.5rem;
        padding-bottom: 3.5rem;
    }
    .featured-bento {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        grid-template-rows: 440px;
        gap: 14px;
    }
    .featured-sub-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, minmax(0, 1fr));
        gap: 14px;
        min-height: 0;
        height: 100%;
    }
    .featured-card {
        position: relative;
        display: block;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1));
        background: #111827;
        text-decoration: none;
        min-height: 0;
        height: 100%;
    }
    .featured-card img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .featured-card:hover img {
        transform: scale(1.04);
    }
    .featured-card:hover {
        border-color: rgba(56, 189, 248, 0.45);
    }
    .featured-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(6, 9, 19, 0.94) 0%, rgba(6, 9, 19, 0.52) 48%, rgba(6, 9, 19, 0.08) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.35rem;
    }
    .featured-sub-grid .featured-overlay {
        padding: 0.95rem 1rem;
    }
    .featured-badge {
        display: inline-block;
        align-self: flex-start;
        background: #f59e0b;
        color: #0b0f19;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        margin-bottom: 0.65rem;
        letter-spacing: 0.01em;
    }
    .featured-main-title {
        color: #ffffff;
        font-size: 1.35rem;
        font-weight: 700;
        line-height: 1.35;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .featured-sub-title {
        color: #ffffff;
        font-size: 0.92rem;
        font-weight: 600;
        line-height: 1.35;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @media (max-width: 991px) {
        .featured-bento {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
        }
        .featured-main-card {
            height: 320px;
        }
        .featured-sub-grid {
            grid-template-rows: auto;
            grid-auto-rows: 190px;
            height: auto;
        }
    }
    @media (max-width: 575px) {
        .featured-sub-grid {
            grid-template-columns: 1fr;
            grid-auto-rows: 200px;
        }
        .featured-main-title {
            font-size: 1.15rem;
        }
    }
</style>
@endsection

@section('konten')
@if(isset($unggulan) && $unggulan->isNotEmpty() && !isset($cari) && !isset($kategori) && !isset($tag))
<section class="featured-blog-section">
    <div class="container">
        <div class="featured-bento reveal">
            @php $mainFeatured = $unggulan->first(); @endphp
            <a href="/blog/{{ $mainFeatured->slug }}" class="featured-card featured-main-card">
                <img src="/storage/{{ $mainFeatured->gambar_utama ?? $mainFeatured->gambar }}?v={{ $mainFeatured->updated_at?->timestamp ?? 1 }}" alt="{{ $mainFeatured->judul }}">
                <div class="featured-overlay">
                    <span class="featured-badge">{{ $mainFeatured->kategoris->first()->nama ?? 'Featured' }}</span>
                    <h1 class="featured-main-title">{{ $mainFeatured->judul }}</h1>
                </div>
            </a>

            <div class="featured-sub-grid">
                @foreach($unggulan->slice(1, 4) as $item)
                <a href="/blog/{{ $item->slug }}" class="featured-card">
                    <img src="/storage/{{ $item->gambar_utama ?? $item->gambar }}?v={{ $item->updated_at?->timestamp ?? 1 }}" alt="{{ $item->judul }}">
                    <div class="featured-overlay">
                        <h2 class="featured-sub-title">{{ $item->judul }}</h2>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@else
<section class="page-header" style="padding-top: 9rem; padding-bottom: 3rem;">
    <div class="container text-center reveal">
        @if(isset($kategori))
            <h1 class="section-title">Category: <span>{{ $kategori->nama }}</span></h1>
        @elseif(isset($tag))
            <h1 class="section-title">Tag: <span>#{{ $tag->nama }}</span></h1>
        @else
            <h1 class="section-title">Latest <span>Insights</span></h1>
            <p class="text-muted">News, tutorials, and innovation updates from the world of custom manufacturing.</p>
        @endif
    </div>
</section>
@endif

<section class="blog-list" style="padding-bottom: 8rem;">
    <div class="container">
        @if(isset($cari))
            <div class="search-result-info reveal" style="margin-bottom: 2rem;">
                <h3>Search results for: "{{ $cari }}"</h3>
            </div>
        @endif

        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
            @forelse($beritaList as $b)
                <div class="blog-card reveal">
                    <div class="blog-image" style="border-radius: 20px; overflow: hidden; height: 250px; border: 1px solid var(--glass-border);">
                        <img src="/storage/{{ $b->gambar_utama ?? $b->gambar }}?v={{ $b->updated_at?->timestamp ?? 1 }}" alt="{{ $b->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="blog-info" style="padding-top: 1.5rem;">
                        <span class="blog-date" style="color: var(--secondary); font-size: 0.9rem;">{{ $b->created_at->format('M d, Y') }}</span>
                        <h3 style="margin-top: 0.5rem; margin-bottom: 1rem;"><a href="/blog/{{ $b->slug }}">{{ $b->judul }}</a></h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">{{ Str::limit(strip_tags($b->isi), 120) }}</p>
                        <a href="/blog/{{ $b->slug }}" class="btn-text" style="display: inline-block; margin-top: 1.5rem; color: var(--primary); font-weight: 600;">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            @empty
                <div class="text-center" style="grid-column: 1/-1; padding: 4rem;">
                    <p class="text-muted">No articles found.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $beritaList->links() }}
        </div>
    </div>
</section>
@endsection
