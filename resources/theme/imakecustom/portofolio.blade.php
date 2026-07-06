@extends('tema::layout')

@section('title', 'Our Showcase | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">The Master <span>Showcase</span></h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto;">Explore our latest collection of custom manufactured parts, rapid prototypes, and precision engineering projects.</p>
    </div>
</section>

<section class="portfolio-page-grid" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="portfolio-filter-large reveal" style="margin-bottom: 3rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <button class="active" data-filter="all">All Projects</button>
            @php
                $categories = DB::table('portofolios')->where('aktif', true)->whereNotNull('kategori')->pluck('kategori')->unique();
            @endphp
            @foreach($categories as $cat)
                <button data-filter="{{ $cat }}">{{ $cat }}</button>
            @endforeach
        </div>

        <div class="portfolio-grid">
            @forelse($portofolios as $p)
                <div class="portfolio-item group reveal" data-category="{{ $p->kategori }}">
                    <img src="/storage/{{ $p->gambar }}" alt="{{ $p->judul }}">
                    <div class="overlay">
                        <h4>{{ $p->judul }}</h4>
                        <p>{{ $p->deskripsi }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center" style="grid-column: 1/-1; padding: 4rem;">
                    <p class="text-muted">No projects found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $portofolios->links() }}
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .portfolio-filter-large button {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
        padding: 0.8rem 2rem;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }
    .portfolio-filter-large button.active, .portfolio-filter-large button:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination-wrapper .pagination { display: flex; gap: 0.5rem; list-style: none; }
    .pagination-wrapper .page-item .page-link {
        width: 45px; height: 45px;
        display: flex; align-items: center; justify-content: center;
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        color: white;
    }
    .pagination-wrapper .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
    }
</style>
@endsection
