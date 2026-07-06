@extends('tema::layout')

@section('title', isset($kategori) ? 'Kategori: ' . $kategori->nama : 'Artikel Terbaru')

@section('konten')
<div class="main-content" style="margin-top: 30px;">
    
    <main>
        <!-- Breadcrumb -->
        <nav style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
            <a href="/">Beranda</a> &raquo; 
            @if(isset($kategori))
                <a href="/artikel">Artikel</a> &raquo; <span>{{ $kategori->nama }}</span>
            @else
                <span>Semua Artikel</span>
            @endif
        </nav>

        <section class="block-header">
            <h2 class="block-title">{{ isset($kategori) ? 'Kategori: ' . $kategori->nama : 'Artikel Terbaru' }}</h2>
            <div class="block-line"></div>
        </section>

        @if($artikelList->count() > 0)
            <div class="grid-layout">
                @foreach($artikelList as $item)
                    <article class="news-card">
                        <div class="news-img">
                            <span class="category-tag">{{ optional($item->kategori)->nama ?? 'Umum' }}</span>
                            <a href="/artikel/{{ $item->slug }}">
                                <img src="{{ $item->gambar_utama ? (str_starts_with($item->gambar_utama, 'http') ? $item->gambar_utama : asset('storage/' . $item->gambar_utama)) : asset('theme/pinterhukum/img/default.jpg') }}" alt="{{ $item->judul }}">
                            </a>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title"><a href="/artikel/{{ $item->slug }}">{{ $item->judul }}</a></h3>
                            <div class="news-meta">
                                <span><i class="far fa-calendar"></i> {{ $item->created_at->format('d M Y') }}</span>
                                <span><i class="far fa-user"></i> {{ $item->penulis->nama ?? 'Admin' }}</span>
                            </div>
                            <p class="news-excerpt">{{ Str::limit($item->ringkasan, 100) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top: 40px;">
                {{ $artikelList->links('vendor.pagination.theme') }}
            </div>
        @else
            <div style="text-align: center; padding: 50px; background: #fff; border-radius: 12px; border: 1px solid var(--border);">
                <i class="fas fa-file-alt" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 20px; opacity: 0.5;"></i>
                <h3 style="color: var(--text-muted);">Belum ada artikel yang diterbitkan.</h3>
            </div>
        @endif

    </main>

    <aside>
        <div class="widget">
            <h4 class="widget-title">Artikel Populer</h4>
            <ul class="popular-list">
                @foreach($artikelPopuler as $idx => $pop)
                <li class="popular-item">
                    <span class="number">{{ $idx + 1 }}</span>
                    <div>
                        <a href="/artikel/{{ $pop->slug }}" class="popular-link">{{ $pop->judul }}</a>
                        <small style="color: var(--text-muted);">{{ $pop->created_at->format('d M Y') }}</small>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        
        <div class="widget" style="position: sticky; top: 100px;">
            <h4 class="widget-title">Pelayanan Jasa Hukum</h4>
            <div style="background: #fffbef; border: 1px solid #fde68a; padding: 15px; border-radius: 8px;">
                <p style="font-size: 0.85rem; color: #92400e;">Anda mencari bantuan hukum atau konsultasi mengenai regulasi terbaru?</p>
                <a href="/kontak" class="btn" style="width: 100%; justify-content: center; margin-top: 15px; background: #92400e; border: none;">Hubungi Kami</a>
            </div>
        </div>
    </aside>

</div>
@endsection
