@extends('tema::layout')

@section('title', 'Galeri Video')

@section('konten')
<!-- Video Hero Section - Full Width -->
<div class="video-hero" style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 100px 0; margin-bottom: 60px; text-align: center; color: #fff; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <h1 style="font-size: 3.8rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px;">Galeri Video</h1>
        <p style="font-size: 1.3rem; opacity: 0.9; max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 500;">Tonton informasi hukum terbaru dalam format video yang informatif dan mudah dipahami.</p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    @if($videos->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            @foreach($videos as $vid)
                @php
                    $url = $vid->url;
                    $embedUrl = '';
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                    } 
                    elseif (preg_match('/(?:vimeo\.com\/)([0-9]+)/', $url, $matches)) {
                        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                    }
                @endphp
                <div class="video-card-premium" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative;">
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; background: #000; overflow: hidden;">
                        @if($embedUrl)
                            <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;" 
                                    src="{{ $embedUrl }}?controls=0&mute=1&showinfo=0&rel=0" 
                                    title="{{ $vid->judul }}" 
                                    frameborder="0"></iframe>
                            <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; transition: background 0.3s;" class="video-overlay">
                                <a href="/video/{{ $vid->slug }}" style="width: 60px; height: 60px; background: rgba(255,255,255,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem; text-decoration: none; box-shadow: 0 10px 20px rgba(0,0,0,0.2); transition: all 0.3s;" class="play-btn">
                                    <i class="fas fa-play" style="margin-left: 5px;"></i>
                                </a>
                            </div>
                        @else
                            <div style="position: absolute; top:0; left:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#fff;">Invalid URL</div>
                        @endif
                    </div>
                    <div style="padding: 30px;">
                        @if($vid->unggulan)
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                <span style="background: #ebf5ff; color: #0369a1; padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">UNGGULAN</span>
                            </div>
                        @endif
                        <h3 style="font-size: 1.25rem; font-weight: 800; line-height: 1.4; margin-bottom: 15px;">
                            <a href="/video/{{ $vid->slug }}" style="color: #1e293b; text-decoration: none; transition: color 0.2s;">{{ $vid->judul }}</a>
                        </h3>
                        <p style="font-size: 0.95rem; color: #64748b; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 25px;">
                            {{ $vid->keterangan }}
                        </p>
                        <a href="/video/{{ $vid->slug }}" class="btn" style="width: 100%; justify-content: center; background: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; font-weight: 700;">
                            Tonton Video <i class="fas fa-arrow-right" style="margin-left: 8px; font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 50px;">
            {{ $videos->links('vendor.pagination.theme') }}
        </div>
    @else
        <div style="text-align: center; padding: 100px 40px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <i class="fas fa-video-slash" style="font-size: 4rem; color: #cbd5e1; margin-bottom:30px;"></i>
            <h3 style="color: var(--text-main); font-size: 1.8rem; margin-bottom: 15px;">Belum ada video</h3>
            <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto;">Kami akan segera mengunggah konten video menarik untuk Anda. Silakan cek kembali nanti.</p>
        </div>
    @endif
</div>
@section('scripts')
<style>
    .video-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .video-card-premium:hover .video-overlay {
        background: rgba(0,0,0,0.4) !important;
    }
    .video-card-premium:hover .play-btn {
        transform: scale(1.1);
        background: var(--primary) !important;
        color: #fff !important;
    }
</style>
@endsection
@endsection
