@extends('tema::layout')

@section('title', $video->judul)

@section('konten')
<div class="container section-padding">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <div style="margin-bottom: 30px;">
            <h1 style="font-size: 32px; margin-bottom: 15px;">{{ $video->judul }}</h1>
            <div style="color: var(--text-muted); font-size: 14px; display: flex; gap: 20px;">
                <span><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($video->created_at)->format('d F Y') }}</span>
                <span><i class="far fa-eye"></i> {{ $video->views }} Views</span>
            </div>
        </div>

        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 20px; box-shadow: var(--shadow); background: #000;">
            <iframe 
                src="https://www.youtube.com/embed/{{ $video->video_id }}?autoplay=1" 
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" 
                allowfullscreen>
            </iframe>
        </div>

        <div style="margin-top: 40px; background: #fff; padding: 30px; border-radius: 20px; box-shadow: var(--shadow);">
            <h3 style="margin-bottom: 15px;">Description</h3>
            <div style="font-size: 16px; color: var(--text-main); line-height: 1.7;">
                {!! $video->keterangan !!}
            </div>
        </div>

        <!-- Related Videos -->
        <div style="margin-top: 60px;">
            <div class="section-title">
                <h2>Up Next</h2>
            </div>
            <div class="masonry-grid">
                @foreach($latestVideos as $item)
                <div class="portfolio-item">
                    <div class="thumb">
                        <a href="/video/{{ $item->slug }}">
                            <img src="{{ $item->thumbnail ? '/storage/'.$item->thumbnail : 'https://img.youtube.com/vi/'.$item->video_id.'/maxresdefault.jpg' }}" alt="{{ $item->judul }}">
                            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.1);">
                                <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px;">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="details">
                        <h4 style="font-size: 16px;"><a href="/video/{{ $item->slug }}">{{ $item->judul }}</a></h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
