@extends('tema::layout')

@section('title', $artikel->judul)

@section('konten')
<div class="main-content" style="margin-top: 30px;">
    
    <main>
        <article class="card" style="padding: 40px; border-radius: 12px; box-shadow: var(--shadow); background: #fff;">
            <div style="margin-bottom: 25px;">
                <span class="hero-tag" style="background: var(--primary);">ARTIKEL</span>
                <h1 style="font-size: 2.5rem; margin-top: 15px; line-height: 1.2;">{{ $artikel->judul }}</h1>
                <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 10px;">
                    Diterbitkan pada {{ $artikel->created_at->format('d F Y') }}
                </div>
            </div>

            <div class="entry-content" style="font-size: 1.1rem; line-height: 1.8; color: #2d3748;">
                {!! $artikel->isi !!}
            </div>
        </article>
    </main>

    <aside>
        <div class="widget">
            <h4 class="widget-title">Edukasi Hukum</h4>
            <p style="font-size: 0.85rem; color: var(--text-muted);">Dapatkan wawasan hukum mendalam melalui artikel-artikel pilihan kami.</p>
        </div>
    </aside>

</div>
@endsection
