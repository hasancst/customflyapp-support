@extends('tema::layout')

@section('title', isset($kategori) ? 'Berita ' . $kategori->nama : (isset($tag) ? 'Tag ' . $tag->nama : 'Berita Terbaru'))

@section('konten')
<!-- Category Hero Section - Full Width -->
@if(isset($kategori))
<div class="category-hero" style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 100px 0; margin-bottom: 50px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    
    <div class="container" style="text-align: center; position: relative; z-index: 1;">
        <nav style="font-size: 0.9rem; margin-bottom: 20px;">
            <a href="/" style="color: rgba(255,255,255,0.8); font-weight: 600;">Beranda</a> 
            <span style="color: rgba(255,255,255,0.4); margin: 0 15px;">/</span>
            <a href="/berita" style="color: rgba(255,255,255,0.8); font-weight: 600;">Berita</a>
            <span style="color: rgba(255,255,255,0.4); margin: 0 15px;">/</span>
            <span style="color: #fff; font-weight: 700;">{{ $kategori->nama }}</span>
        </nav>
        <h1 style="color: #fff; font-size: 4rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -2px;">{{ $kategori->nama }}</h1>
        <p style="color: rgba(255,255,255,0.9); font-size: 1.25rem; max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 500;">
            @if($kategori->deskripsi)
                {{ $kategori->deskripsi }}
            @else
                Kumpulan informasi dan berita hukum terbaru serta terpercaya seputar {{ strtolower($kategori->nama) }} di Indonesia.
            @endif
        </p>
    </div>
</div>
@elseif(isset($tag))
<div class="category-hero" style="background: linear-gradient(135deg, #059669 0%, #064e3b 100%); padding: 100px 0; margin-bottom: 50px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    
    <div class="container" style="text-align: center; position: relative; z-index: 1;">
        <nav style="font-size: 0.9rem; margin-bottom: 20px;">
            <a href="/" style="color: rgba(255,255,255,0.8); font-weight: 600;">Beranda</a> 
            <span style="color: rgba(255,255,255,0.4); margin: 0 15px;">/</span>
            <a href="/berita" style="color: rgba(255,255,255,0.8); font-weight: 600;">Berita</a>
            <span style="color: rgba(255,255,255,0.4); margin: 0 15px;">/</span>
            <span style="color: #fff; font-weight: 700;">Tag</span>
        </nav>
        <h1 style="color: #fff; font-size: 4rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -2px;">#{{ $tag->nama }}</h1>
        <p style="color: rgba(255,255,255,0.9); font-size: 1.25rem; max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 500;">
            Menampilkan semua berita dengan tagar #{{ strtolower($tag->nama) }} di Rumah Koalisi.
        </p>
    </div>
</div>
@elseif(isset($cari))
<div class="category-hero" style="background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%); padding: 100px 0; margin-bottom: 50px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div style="position: absolute; top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    <div class="container" style="text-align: center; position: relative; z-index: 1;">
        <h1 style="color: #fff; font-size: 3.5rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -1px;">Hasil Pencarian</h1>
        <p style="color: rgba(255,255,255,0.9); font-size: 1.5rem; max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 500;">
            Ditemukan {{ $beritaList->total() + (isset($featured) ? 1 : 0) }} hasil untuk kata kunci: <span style="color: #fbbf24; text-decoration: underline;">"{{ $cari }}"</span>
        </p>
    </div>
</div>
@endif

<div class="container">
<div class="main-content" style="margin-top: 40px;">
    <main>
        @if($beritaList->count() > 0)
            <!-- Featured Post in Category (First Item) -->
            @php $featured = $beritaList->shift(); @endphp
            <div class="featured-card-premium" style="margin-top: 20px; margin-bottom: 40px; position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); background: #fff;">
                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 0;">
                    <div style="height: 400px; overflow: hidden; position: relative;">
                         <img src="{{ $featured->gambar_utama ? (str_starts_with($featured->gambar_utama, 'http') ? $featured->gambar_utama : asset('storage/' . $featured->gambar_utama)) : asset('theme/pinterhukum/img/default.jpg') }}" 
                              style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" 
                              alt="{{ $featured->judul }}"
                              class="featured-img-hover">
                         <div style="position: absolute; top: 20px; left: 20px; background: var(--primary); color: #fff; padding: 5px 15px; border-radius: 4px; font-weight: 700; font-size: 0.75rem; letter-spacing: 1px;">TERBARU</div>
                    </div>
                    <div style="padding: 40px; display: flex; flex-direction: column; justify-content: center;">
                        <div style="color: var(--primary); font-weight: 700; font-size: 0.85rem; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px;">
                            {{ $featured->kategoris->first()->nama ?? 'BERITA' }}
                        </div>
                        <h2 style="font-size: 2.2rem; line-height: 1.2; margin-bottom: 20px; font-weight: 800;">
                            <a href="/berita/{{ $featured->kategoris->first()->slug ?? 'umum' }}/{{ $featured->slug }}" style="color: var(--text-main); text-decoration: none;">{{ $featured->judul }}</a>
                        </h2>
                        <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 25px; font-size: 1.05rem;">
                            {{ Str::limit($featured->ringkasan, 150) }}
                        </p>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($featured->penulis->nama ?? 'A') }}&background=014A7A&color=fff" style="width: 40px; height: 40px; border-radius: 50%;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem;">{{ $featured->penulis->nama ?? 'Administrator' }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $featured->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid for Remaining Posts -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
                @foreach($beritaList as $item)
                    <article class="premium-card">
                        <div class="card-image-box">
                            <a href="/berita/{{ $item->kategoris->first()->slug ?? 'umum' }}/{{ $item->slug }}">
                                <img src="{{ $item->gambar_utama ? (str_starts_with($item->gambar_utama, 'http') ? $item->gambar_utama : asset('storage/' . $item->gambar_utama)) : asset('theme/pinterhukum/img/default.jpg') }}" alt="{{ $item->judul }}">
                            </a>
                        </div>
                        <div class="card-body-box">
                            <div class="tag-meta">{{ $item->created_at->format('d M Y') }}</div>
                            <h3 class="card-title-box"><a href="/berita/{{ $item->kategoris->first()->slug ?? 'umum' }}/{{ $item->slug }}">{{ $item->judul }}</a></h3>
                            <p class="card-excerpt-box">{{ Str::limit($item->ringkasan, 100) }}</p>
                            <div class="card-footer-box">
                                <span><i class="far fa-user"></i> {{ $item->penulis->nama ?? 'Admin' }}</span>
                                <a href="/berita/{{ $item->kategoris->first()->slug ?? 'umum' }}/{{ $item->slug }}" class="read-more-link">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top: 50px;">
                {{ $beritaList->links('vendor.pagination.theme') }}
            </div>
        @else
            <div style="text-align: center; padding: 100px 40px; background: #fff; border-radius: 20px; box-shadow: var(--shadow); border: 1px solid #e2e8f0;">
                <div style="width: 120px; height: 120px; background: #fdf2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                    <i class="fas fa-search" style="font-size: 3.5rem; color: #ef4444;"></i>
                </div>
                <h2 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 15px;">{{ isset($cari) ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Berita' }}</h2>
                <p style="color: #64748b; font-size: 1.1rem; max-width: 500px; margin: 0 auto 30px; line-height: 1.6;">
                    {{ isset($cari) ? "Maaf, kami tidak dapat menemukan berita yang cocok dengan kata kunci \"$cari\". Silakan coba menggunakan kata kunci lain." : "Sepertinya belum ada berita yang diterbitkan di kategori ini. Silakan kembali lagi nanti." }}
                </p>
                <a href="/berita" class="btn-premium" style="display: inline-block; padding: 15px 35px; background: var(--primary); color: #fff; text-decoration: none; border-radius: 50px; font-weight: 700; transition: all 0.3s; box-shadow: 0 10px 20px rgba(78, 115, 223, 0.2);">
                    Lihat Semua Berita
                </a>
            </div>
        @endif

    </main>

    <aside>
        <div class="widget">
            <h4 class="widget-title">Top News</h4>
            <ul style="list-style: none; padding: 0;">
                @foreach($topBerita as $top)
                <li style="display: flex; gap: 12px; margin-bottom: 20px; align-items: flex-start;">
                    <div style="width: 80px; height: 55px; min-width: 80px; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <img src="{{ $top->gambar_utama ? (str_starts_with($top->gambar_utama, 'http') ? $top->gambar_utama : asset('storage/' . $top->gambar_utama)) : asset('theme/pinterhukum/img/default.jpg') }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                        <a href="/berita/{{ $top->kategoris->first()->slug ?? 'umum' }}/{{ $top->slug }}" style="text-decoration: none; color: var(--text-main); font-size: 0.9rem; font-weight: 700; line-height: 1.3; display: block; margin-bottom: 3px;">{{ Str::limit($top->judul, 45) }}</a>
                        <small style="color: var(--text-muted); font-size: 0.75rem;">{{ $top->created_at->format('d M Y') }}</small>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        
        <div class="widget" style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); color: #fff; border: none;">
            <h4 class="widget-title" style="color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">Berlangganan</h4>
            <div style="padding: 5px;">
                <div style="display: flex; align-items: center; justify-content: center; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%; margin-bottom: 20px;">
                    <i class="fas fa-paper-plane" style="font-size: 1.2rem; color: #fff;"></i>
                </div>
                <h5 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; color: #fff;">Update Hukum Terbaru</h5>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.8); margin-bottom: 20px; line-height: 1.5;">Dapatkan pembaruan berita dan analisis hukum terpercaya langsung di email Anda setiap minggu.</p>
                <form onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');" style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--primary); font-size: 0.8rem;">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" placeholder="Alamat Email Anda" required style="width: 100%; padding: 12px 12px 12px 35px; border: none; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff;">
                    </div>
                    <button class="btn" style="width: 100%; justify-content: center; background: #fbbf24; color: #000; border: none; font-weight: 800; padding: 12px; border-radius: 8px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);">
                        SAYA MAU LANGGANAN
                    </button>
                    <p style="font-size: 0.7rem; color: rgba(255,255,255,0.5); text-align: center; margin-top: 5px;">*Kami menghargai privasi Anda</p>
                </form>
            </div>
        </div>

        <div class="widget" style="position: sticky; top: 100px;">
            <h4 class="widget-title">Sponsor</h4>
            <div style="border-radius: 12px; overflow: hidden; box-shadow: var(--shadow);">
                <img src="{{ asset('theme/pinterhukum/img/ad-side.jpg') }}" onerror="this.src='https://placehold.co/300x600?text=Iklan+Premium'" style="width: 100%; display: block;">
            </div>
        </div>
    </aside>

</div>
</div>

<style>
    /* Premium Redesign Styles */
    .premium-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        border: 1px solid #f1f5f9;
        height: 100%;
    }

    .premium-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .card-image-box {
        height: 220px;
        overflow: hidden;
    }

    .card-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .premium-card:hover .card-image-box img {
        transform: scale(1.1);
    }

    .card-body-box {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .tag-meta {
        font-size: 0.75rem;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-title-box {
        font-size: 1.3rem;
        margin-bottom: 15px;
        line-height: 1.4;
        font-weight: 700;
    }

    .card-title-box a {
        color: var(--text-main);
        text-decoration: none;
        transition: color 0.2s;
    }

    .card-title-box a:hover {
        color: var(--primary);
    }

    .card-excerpt-box {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .card-footer-box {
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #64748b;
    }

    .read-more-link {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .read-more-link:hover {
        text-decoration: underline;
    }

    .featured-card-premium:hover .featured-img-hover {
        transform: scale(1.05);
    }

    @media (max-width: 991px) {
        .featured-card-premium { grid-template-columns: 1fr !important; }
        .featured-card-premium > div { grid-template-columns: 1fr !important; }
        .featured-card-premium img { height: 250px !important; }
    }

    @media (max-width: 768px) {
        .main-content { grid-template-columns: 1fr !important; }
        .grid-layout { grid-template-columns: 1fr !important; }
        div[style*="grid-template-columns: repeat(2, 1fr)"] { grid-template-columns: 1fr !important; }
        .category-hero h1 { font-size: 2.2rem !important; }
        .category-hero nav { display: none !important; }
        .category-hero { padding: 50px 0 !important; }
        .featured-card-premium > div { display: flex !important; flex-direction: column !important; }
        .featured-card-premium img { height: 200px !important; }
    }
</style>
@endsection
