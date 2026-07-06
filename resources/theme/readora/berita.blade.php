@extends('tema::layout')

@section('title', $berita->judul)

@section('styles')
<style>
    .project-header {
        background-color: var(--purple-dark);
        padding: 180px 0 100px;
        color: #fff;
        text-align: center;
    }

    .project-title {
        font-size: 56px;
        color: #fff;
        margin-bottom: 25px;
        line-height: 1.2;
    }

    .project-meta {
        display: flex;
        justify-content: center;
        gap: 30px;
        font-weight: 600;
        opacity: 0.8;
    }

    .project-meta i { color: var(--primary); margin-right: 8px; }

    .project-content {
        margin-top: -80px;
        background: #fff;
        border-radius: 40px;
        padding: 60px;
        box-shadow: var(--shadow-hover);
        position: relative;
        z-index: 5;
    }

    .featured-img {
        width: 100%;
        border-radius: 30px;
        margin-bottom: 50px;
        box-shadow: var(--shadow);
    }

    .rich-content {
        font-size: 20px;
        line-height: 1.8;
        color: var(--body-text);
    }

    .rich-content p { margin-bottom: 25px; }

    .tag-pill {
        display: inline-block;
        padding: 8px 20px;
        background: var(--bg-light);
        color: var(--purple);
        border-radius: 50px;
        font-weight: 700;
        margin-right: 10px;
        margin-bottom: 15px;
        transition: var(--transition);
    }

    .tag-pill:hover { background: var(--primary-grad); color: #fff; }

    @media (max-width: 768px) {
        .project-title { font-size: 36px; }
        .project-content { padding: 30px; margin-top: -50px; }
        .project-meta { flex-direction: column; gap: 10px; }
    }
</style>
@endsection

@section('konten')

<!-- Project Header -->
<section class="project-header">
    <div class="container">
        <span style="color: var(--primary); font-weight: 800; letter-spacing: 2px; text-transform: uppercase;">{{ $berita->kategoris->first()->nama ?? 'Case Study' }}</span>
        <h1 class="project-title">{{ $berita->judul }}</h1>
        <div class="project-meta">
            <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}</span>
            <span><i class="fas fa-user"></i> {{ $berita->penulis->nama ?? 'Admin' }}</span>
            <span><i class="fas fa-eye"></i> {{ $berita->views }} Views</span>
        </div>
    </div>
</section>

<!-- Project Content -->
<div class="container">
    <article class="project-content">
        @if($berita->gambar_utama)
        <img src="/storage/{{ $berita->gambar_utama }}" alt="{{ $berita->judul }}" class="featured-img">
        @endif
        
        <div class="rich-content">
            {!! $berita->isi !!}
        </div>

        @if($berita->tags->isNotEmpty())
        <div style="margin-top: 60px; padding-top: 40px; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 20px;">Project Tags</h4>
            <div>
                @foreach($berita->tags as $t)
                    <a href="#" class="tag-pill">#{{ $t->nama }}</a>
                @endforeach
            </div>
        </div>
        @endif
    </article>

    <!-- Related Work -->
    <section class="section-padding">
        <div style="margin-bottom: 40px; text-align: center;">
            <h2 style="font-size: 32px;">More Projects</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
            @foreach($beritaTerkait as $item)
            <div style="background: #fff; border-radius: 30px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition);">
                <div style="height: 240px; overflow: hidden;">
                    <a href="/berita/{{ $item->slug }}">
                        @if($item->gambar_utama)
                        <img src="/storage/{{ $item->gambar_utama }}" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $item->judul }}">
                        @else
                        <div style="width: 100%; height: 100%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
                        @endif
                    </a>
                </div>
                <div style="padding: 25px;">
                    <h4 style="font-size: 20px;"><a href="/berita/{{ $item->slug }}">{{ $item->judul }}</a></h4>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

@endsection
