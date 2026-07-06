@extends('tema::layout')

@section('title', 'Knowledge Base | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">Knowledge <span>Base</span></h1>
        <p class="text-muted">Technical guides, case studies, and detailed documentation for our manufacturing services.</p>
    </div>
</section>

<section class="blog-list" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
            @forelse($artikelList as $a)
                <div class="blog-card reveal">
                    <div class="blog-image" style="border-radius: 20px; overflow: hidden; height: 250px; border: 1px solid var(--glass-border);">
                        <img src="/storage/{{ $a->gambar }}" alt="{{ $a->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="blog-info" style="padding-top: 1.5rem;">
                        <span class="blog-category" style="color: var(--secondary); font-size: 0.9rem;">{{ $a->kategori->judul ?? 'General' }}</span>
                        <h3 style="margin-top: 0.5rem; margin-bottom: 1rem;"><a href="/artikel/{{ $a->slug }}">{{ $a->judul }}</a></h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">{{ Str::limit(strip_tags($a->konten), 120) }}</p>
                        <a href="/artikel/{{ $a->slug }}" class="btn-text" style="display: inline-block; margin-top: 1.5rem; color: var(--primary); font-weight: 600;">Read Technical File <i class="fas fa-file-pdf"></i></a>
                    </div>
                </div>
            @empty
                <div class="text-center" style="grid-column: 1/-1; padding: 4rem;">
                    <p class="text-muted">No technical articles found.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $artikelList->links() }}
        </div>
    </div>
</section>
@endsection
