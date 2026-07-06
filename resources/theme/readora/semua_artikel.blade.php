@extends('tema::layout')

@section('title', 'Articles & Stories')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div class="section-title">
            <span>Knowledge Base</span>
            <h2>Latest Articles</h2>
        </div>
        
        <div class="masonry-grid">
            @foreach($artikelList as $item)
            <div class="portfolio-item">
                <div class="thumb">
                    <a href="/artikel/{{ $item->slug }}">
                        <img src="/storage/{{ $item->gambar }}" alt="{{ $item->judul }}">
                    </a>
                </div>
                <div class="details">
                    <h3 class="title"><a href="/artikel/{{ $item->slug }}">{{ $item->judul }}</a></h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 15px;">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                    <div class="meta">
                         <span><i class="far fa-user"></i> {{ $item->penulis->name ?? 'Admin' }}</span>
                         <span><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 50px; text-align: center;">
             {{ $artikelList->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
