@extends('tema::layout')

@section('title', 'Portofolio Kami - ' . ($pengaturan['nama_situs'] ?? 'Rumah Cyber'))

@section('konten')
<section class="section-padding" style="background: var(--purple-dark); color: #fff; padding: 120px 0 60px;">
    <div class="container text-center">
        <h1 style="font-size: 48px; font-weight: 900; margin-bottom: 20px; color: #fff;">Our Portofolio</h1>
        <p style="font-size: 18px; opacity: 0.8; max-width: 600px; margin: 0 auto;">
            @if(request('tag'))
                Menampilkan hasil untuk tag: <span style="color: var(--primary); font-weight: 700;">#{{ request('tag') }}</span>
            @else
                Kumpulan karya terbaik yang telah kami selesaikan dengan sepenuh hati.
            @endif
        </p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        @if($portofolios->isEmpty())
            <div style="text-align: center; padding: 100px 0;">
                <i class="fas fa-search" style="font-size: 4rem; color: var(--border); margin-bottom: 20px; display: block;"></i>
                <h3 style="color: var(--text-muted);">Maaf, portofolio tidak ditemukan.</h3>
                <a href="/portofolio" class="btn-cmn" style="margin-top: 20px;">Lihat Semua Portofolio</a>
            </div>
        @else
            <div class="portfolio-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
                @foreach($portofolios as $item)
                <div class="readora-card">
                    <div class="card-thumb" style="position: relative; height: 280px; overflow: hidden; border-radius: 30px 30px 0 0;">
                        @php
                            $imgPath = (strpos($item->gambar, 'http') === 0) ? $item->gambar : '/storage/' . $item->gambar;
                        @endphp
                        <a href="{{ $item->url ?? '#' }}">
                            <img src="{{ $imgPath }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                        </a>
                    </div>
                    <div class="card-content" style="padding: 30px; background: #fff; border-radius: 0 0 30px 30px;">
                        <span class="card-cat" style="font-size: 14px; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 10px; display: block;">{{ $item->kategori ?? 'Proyek' }}</span>
                        <h3 style="font-size: 22px; margin-bottom: 10px;"><a href="{{ $item->url ?? '#' }}" style="color: var(--purple-dark); font-weight: 800;">{{ $item->judul }}</a></h3>
                        
                        @if($item->tags)
                        <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 15px;">
                            @foreach(explode(',', $item->tags) as $tag)
                            <a href="/portofolio?tag={{ urlencode(trim($tag)) }}" style="background: var(--bg-light); color: var(--primary); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;">{{ trim($tag) }}</a>
                            @endforeach
                        </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 14px; color: var(--text-muted);">{{ $item->klien ?? 'Client' }}</span>
                            <a href="{{ $item->url ?? '#' }}" style="color: var(--primary); font-weight: 700;">View Project <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-top: 60px; display: flex; justify-content: center;">
                {{ $portofolios->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</section>

<style>
    .readora-card:hover .card-thumb img {
        transform: scale(1.1);
    }
    .readora-card {
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .readora-card:hover {
        transform: translateY(-10px);
    }
</style>
@endsection
