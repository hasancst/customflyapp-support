@extends('tema::layout')

@section('title', 'Video Gallery | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">Video <span>Gallery</span></h1>
        <p class="text-muted">Watch our production line in action and see our latest projects come to life.</p>
    </div>
</section>

<section class="video-list" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="video-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
            @forelse($videos as $v)
                <div class="video-card reveal">
                    <div class="video-thumb" style="border-radius: 20px; overflow: hidden; height: 200px; border: 1px solid var(--glass-border); position: relative;">
                        <img src="https://img.youtube.com/vi/{{ $v->youtube_id }}/maxresdefault.jpg" alt="{{ $v->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="play-btn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-play"></i>
                        </div>
                        <a href="/video/{{ $v->slug }}" style="position: absolute; inset: 0;"></a>
                    </div>
                    <div class="video-info" style="padding-top: 1rem;">
                        <h3 style="font-size: 1.1rem;"><a href="/video/{{ $v->slug }}">{{ $v->judul }}</a></h3>
                    </div>
                </div>
            @empty
                <div class="text-center" style="grid-column: 1/-1; padding: 4rem;">
                    <p class="text-muted">No videos found.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $videos->links() }}
        </div>
    </div>
</section>
@endsection
