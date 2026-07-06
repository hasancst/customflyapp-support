@extends('tema::layout')

@section('title', $video->judul)

@section('konten')
<div class="video-detail-page">
    <!-- Header Section -->
    <div class="video-hero" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 80px 0 150px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="container">
            <nav style="font-size: 0.9rem; margin-bottom: 25px;">
                <a href="/" style="color: rgba(255,255,255,0.6); text-decoration: none;">Beranda</a> 
                <span style="color: rgba(255,255,255,0.3); margin: 0 10px;">/</span>
                <a href="/video" style="color: rgba(255,255,255,0.6); text-decoration: none;">Video</a>
                <span style="color: rgba(255,255,255,0.3); margin: 0 10px;">/</span>
                <span style="color: #fff;">{{ $video->judul }}</span>
            </nav>
            <h1 style="color: #fff; font-size: 3rem; font-weight: 800; line-height: 1.2; margin-bottom: 0; letter-spacing: -1px;">{{ $video->judul }}</h1>
        </div>
    </div>

    <div class="container" style="margin-top: 130px !important; margin-bottom: 80px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
            <!-- Main Content -->
            <main>
                <div style="background: #000; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; padding-top: 56.25%;">
                    @php
                        $embed_url = $video->url;
                        if (strpos($embed_url, 'youtube.com/watch?v=') !== false) {
                            $video_id = explode('v=', $embed_url)[1];
                            $video_id = explode('&', $video_id)[0];
                            $embed_url = "https://www.youtube.com/embed/" . $video_id;
                        } elseif (strpos($embed_url, 'youtu.be/') !== false) {
                            $video_id = explode('youtu.be/', $embed_url)[1];
                            $embed_url = "https://www.youtube.com/embed/" . $video_id;
                        } elseif (strpos($embed_url, 'vimeo.com/') !== false) {
                            $video_id = explode('vimeo.com/', $embed_url)[1];
                            $embed_url = "https://player.vimeo.com/video/" . $video_id;
                        }
                    @endphp
                    <iframe 
                        src="{{ $embed_url }}" 
                        style="position: absolute; top:0; left:0; width: 100%; height: 100%; border:none;" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>

                <div style="background: #fff; padding: 40px; border-radius: 24px; margin-top: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; color: #64748b; font-size: 0.95rem;">
                        <span style="background: #f1f5f9; padding: 6px 15px; border-radius: 50px; color: var(--primary); font-weight: 700;">VIDEO</span>
                        <span><i class="far fa-calendar-alt"></i> {{ $video->created_at->format('d M Y') }}</span>
                    </div>
                    
                    <div class="video-description" style="line-height: 1.8; color: #334155; font-size: 1.1rem;">
                        {!! nl2br(e($video->keterangan)) !!}
                    </div>

                    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #f1f5f9; display: flex; gap: 15px;">
                        <span style="font-weight: 700; color: #1e293b;">Bagikan:</span>
                        <a href="#" style="color: #64748b; font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
                        <a href="#" style="color: #64748b; font-size: 1.2rem;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: #64748b; font-size: 1.2rem;"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </main>

            <!-- Sidebar -->
            <aside>
                <div style="background: #fff; padding: 30px; border-radius: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 25px; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                        <span style="width: 4px; height: 20px; background: var(--primary); border-radius: 10px;"></span>
                        Video Terkait
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @foreach($videoTerkait as $vt)
                            <a href="/video/{{ $vt->slug }}" style="text-decoration: none; display: flex; gap: 15px; group">
                                <div style="flex-shrink: 0; width: 100px; height: 60px; background: #000; border-radius: 8px; overflow: hidden; position: relative;">
                                    @php
                                        $thumb_url = "";
                                        if (strpos($vt->url, 'youtube.com/watch?v=') !== false) {
                                            $v_id = explode('v=', $vt->url)[1];
                                            $v_id = explode('&', $v_id)[0];
                                            $thumb_url = "https://img.youtube.com/vi/$v_id/mqdefault.jpg";
                                        } elseif (strpos($vt->url, 'youtu.be/') !== false) {
                                            $v_id = explode('youtu.be/', $vt->url)[1];
                                            $thumb_url = "https://img.youtube.com/vi/$v_id/mqdefault.jpg";
                                        }
                                    @endphp
                                    @if($thumb_url)
                                        <img src="{{ $thumb_url }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                                    @endif
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 0.8rem;">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 style="font-size: 0.95rem; line-height: 1.4; color: #1e293b; font-weight: 700; margin-bottom: 5px; transition: color 0.2s;">{{ Str::limit($vt->judul, 50) }}</h4>
                                    <small style="color: #64748b;">{{ $vt->created_at->format('d M Y') }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <a href="/video" class="btn" style="width: 100%; margin-top: 30px; justify-content: center; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                        Lihat Semua Video
                    </a>
                </div>

                <!-- Ad Widget -->
                <div style="margin-top: 30px; border-radius: 20px; overflow: hidden;">
                    <img src="https://placehold.co/400x600/f1f5f9/64748b?text=Ruang+Iklan+Premium" style="width: 100%; display: block;">
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
    .video-detail-page { background: #f8fafc; min-height: 100vh; }
    .video-description p { margin-bottom: 20px; }
    .read-more-link:hover { text-decoration: underline; }
    
    @media (max-width: 991px) {
        .video-detail-page .container .grid-layout {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
