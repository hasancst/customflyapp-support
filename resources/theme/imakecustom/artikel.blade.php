@extends('tema::layout')

@section('title', ($artikel->judul ?? 'Article') . ' | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">{{ $artikel->judul ?? 'Article' }}</h1>
        @if(isset($artikel->kategori))
            <p class="text-muted">{{ $artikel->kategori }}</p>
        @endif
    </div>
</section>

<section class="page-content" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="glass-card reveal" style="padding: 4rem; min-height: 400px; line-height: 1.8;">
            @if(isset($artikel->gambar))
                <img src="/storage/{{ $artikel->gambar }}" alt="{{ $artikel->judul }}" style="width: 100%; border-radius: 20px; margin-bottom: 3rem;">
            @endif
            
            <div class="article-body">
                {!! $artikel->konten ?? 'No content available.' !!}
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .article-body h2 { margin: 2rem 0 1rem; color: var(--primary); }
    .article-body p { margin-bottom: 1.5rem; color: var(--text-main); font-size: 1.1rem; }
    .article-body ul, .article-body ol { margin-bottom: 1.5rem; padding-left: 1.5rem; }
    .article-body li { margin-bottom: 0.5rem; }
</style>
@endsection
