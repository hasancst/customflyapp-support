@extends('tema::layout')

@section('title', 'Video Gallery')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div class="section-title">
            <span>Visual Stories</span>
            <h2>Video Portfolio</h2>
        </div>
        
        <div class="masonry-grid">
            @foreach($videos as $item)
            <div class="portfolio-item">
                <div class="thumb">
                    <a href="/video/{{ $item->slug }}">
                        <img src="{{ $item->thumbnail ? '/storage/'.$item->thumbnail : 'https://img.youtube.com/vi/'.$item->video_id.'/maxresdefault.jpg' }}" alt="{{ $item->judul }}">
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.2);">
                            <div style="width: 60px; height: 60px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px;">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="details">
                    <h3 class="title"><a href="/video/{{ $item->slug }}">{{ $item->judul }}</a></h3>
                    <div class="meta">
                         <span><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 50px; text-align: center;">
             {{ $videos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
