@extends('tema::layout')

@section('title', $video->judul . ' | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="video-detail-page" style="padding-top: 10rem; padding-bottom: 8rem;">
    <div class="container">
        <div class="video-player-wrapper reveal" style="margin-bottom: 3rem; aspect-ratio: 16/9; border-radius: 30px; overflow: hidden; border: 1px solid var(--glass-border); background: black;">
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $video->youtube_id }}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>

        <div class="video-meta reveal" style="margin-bottom: 4rem;">
            <h1 class="section-title" style="margin-bottom: 1rem;">{{ $video->judul }}</h1>
            <p class="text-muted" style="font-size: 1.1rem; line-height: 1.6;">{{ $video->deskripsi }}</p>
        </div>

        <div class="related-videos">
            <h2 style="margin-bottom: 2rem;">Related Videos</h2>
            <div class="video-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                @foreach($videoTerkait as $vt)
                    <div class="video-card reveal">
                        <div class="video-thumb" style="border-radius: 16px; overflow: hidden; height: 160px; border: 1px solid var(--glass-border); position: relative;">
                            <img src="https://img.youtube.com/vi/{{ $vt->youtube_id }}/mqdefault.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                            <a href="/video/{{ $vt->slug }}" style="position: absolute; inset: 0;"></a>
                        </div>
                        <h4 style="margin-top: 0.8rem; font-size: 0.95rem;"><a href="/video/{{ $vt->slug }}">{{ $vt->judul }}</a></h4>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
