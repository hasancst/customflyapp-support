@extends('tema::layout')

@section('title', isset($cari) ? 'Search Results: ' . $cari : 'Our Projects')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div class="section-title">
            <span>{{ isset($cari) ? 'Showing results for "' . $cari . '"' : 'Latest Work' }}</span>
            <h2>Our Portfolio</h2>
        </div>
        
        <div class="masonry-grid">
            @foreach($beritaList as $item)
            <div class="portfolio-item">
                <div class="thumb">
                    <a href="/berita/{{ $item->slug }}">
                        <img src="/storage/{{ $item->gambar }}" alt="{{ $item->judul }}">
                    </a>
                    @if($item->kategoris->isNotEmpty())
                        <div style="position: absolute; top: 15px; left: 15px; background: var(--primary); color: #fff; padding: 4px 10px; font-size: 11px; font-weight: 700; border-radius: 4px; text-transform: uppercase;">
                            {{ $item->kategoris->first()->nama }}
                        </div>
                    @endif
                </div>
                <div class="details">
                    <h3 class="title"><a href="/berita/{{ $item->slug }}">{{ $item->judul }}</a></h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 15px;">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                    <div class="meta">
                         <span><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                         <span><i class="far fa-eye"></i> {{ $item->views }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($beritaList->isEmpty())
            <div style="text-align: center; padding: 100px 0;">
                <i class="fas fa-search" style="font-size: 60px; color: var(--border); margin-bottom: 20px; display: block;"></i>
                <h3>No results found</h3>
                <p>Try searching with different keywords.</p>
                <a href="/berita" class="btn" style="margin-top: 20px;">Clear Search</a>
            </div>
        @endif

        <div style="margin-top: 50px; text-align: center;">
             {{ $beritaList->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
