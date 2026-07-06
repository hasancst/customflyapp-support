@extends('tema::layout')

@section('title', $artikel->judul)

@section('konten')

<div class="container section-padding">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 40px; line-height: 1.2; margin-bottom: 20px;">{{ $artikel->judul }}</h1>
            <div style="color: var(--text-muted); font-size: 14px;">
                <span>By <strong>{{ $artikel->penulis->name ?? 'Admin' }}</strong></span>
                <span style="margin: 0 10px;">•</span>
                <span>{{ \Carbon\Carbon::parse($artikel->created_at)->format('d F Y') }}</span>
                <span style="margin: 0 10px;">•</span>
                <span>{{ $artikel->views }} Views</span>
            </div>
        </div>

        @if($artikel->gambar)
        <div style="margin-bottom: 40px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow);">
            <img src="/storage/{{ $artikel->gambar }}" alt="{{ $artikel->judul }}" style="width: 100%; display: block;">
        </div>
        @endif

        <div class="content-body" style="font-size: 18px; color: var(--text-main); line-height: 1.8;">
            {!! $artikel->konten !!}
        </div>

        <div style="margin-top: 50px; padding: 40px; background: #fff; border-radius: 20px; box-shadow: var(--shadow); display: flex; gap: 20px; align-items: center;">
            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($artikel->penulis->name ?? 'Admin') }}&background=FF4C60&color=fff" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div>
                <h4 style="margin-bottom: 5px;">{{ $artikel->penulis->name ?? 'Admin' }}</h4>
                <p style="font-size: 14px; color: var(--text-muted);">Content creator and design enthusiast. Passionate about sharing knowledge and inspiring others through creative storytelling.</p>
            </div>
        </div>

    </div>
</div>

@endsection
