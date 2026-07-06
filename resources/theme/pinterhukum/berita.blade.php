@extends('tema::layout')

@section('title', $berita->judul)

@section('konten')
<div class="container">
<div class="main-content" style="margin-top: 30px;">
    
    <main>
        <!-- Mini Breaking News Slider -->
        <div class="breaking-news-ticker" style="background: #fff; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); height: 40px;">
            <div style="background: var(--primary); color: #fff; padding: 0 15px; height: 100%; display: flex; align-items: center; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; position: relative;">
                TERBARU
                <div style="position: absolute; right: -8px; top: 0; bottom: 0; width: 0; height: 0; border-top: 20px solid transparent; border-bottom: 20px solid transparent; border-left: 8px solid var(--primary);"></div>
            </div>
            <div id="ticker-slider" style="flex: 1; padding: 0 25px; height: 100%; position: relative; overflow: hidden;">
                @foreach($topBerita as $idx => $top)
                <div class="ticker-item" style="position: absolute; width: 100%; height: 100%; display: flex; align-items: center; transition: all 0.5s ease; opacity: {{ $idx == 0 ? '1' : '0' }}; visibility: {{ $idx == 0 ? 'visible' : 'hidden' }}; transform: translateY({{ $idx == 0 ? '0' : '20px' }});">
                    <a href="/berita/{{ $top->kategoris->first()->slug ?? 'umum' }}/{{ $top->slug }}" style="text-decoration: none; color: var(--text-main); font-size: 0.85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">
                        {{ $top->judul }}
                    </a>
                </div>
                @endforeach
            </div>
            <div style="display: flex; gap: 5px; padding-right: 15px;">
                <button onclick="prevTicker()" style="background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 0.7rem;"><i class="fas fa-chevron-left"></i></button>
                <button onclick="nextTicker()" style="background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 0.7rem;"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Premium Breadcrumb -->
        <nav class="breadcrumb-nav" style="margin-bottom: 25px; padding: 12px 20px; background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 10px; font-size: 0.85rem;">
            <a href="/" style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                <i class="fas fa-home" style="font-size: 0.8rem;"></i> Beranda
            </a>
            <span style="color: #cbd5e1;"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i></span>
            <a href="/berita" style="color: var(--primary); text-decoration: none; font-weight: 600;">Berita</a>
            
            @if($berita->kategoris->first())
                <span style="color: #cbd5e1;"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i></span>
                <a href="/kategori-berita/{{ $berita->kategoris->first()->slug }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">{{ $berita->kategoris->first()->nama }}</a>
            @endif

            <span style="color: #cbd5e1;"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i></span>
            <span style="color: var(--text-muted); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px;">{{ $berita->judul }}</span>
        </nav>

        <article class="card" style="padding: 40px; border-radius: 12px; box-shadow: var(--shadow); background: #fff;">
            <div style="margin-bottom: 25px;">
                @if($berita->kategoris->first())
                    <a href="/kategori-berita/{{ $berita->kategoris->first()->slug }}" class="hero-tag">{{ $berita->kategoris->first()->nama }}</a>
                @else
                    <span class="hero-tag">BERITA</span>
                @endif
                <h1 class="detail-title" style="font-size: 2.5rem; margin-top: 15px; line-height: 1.2;">{{ $berita->judul }}</h1>
                
                <div style="display: flex; align-items: center; gap: 15px; margin-top: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($berita->penulis->nama ?? 'A') }}&background=014A7A&color=fff" style="width: 45px; height: 45px; border-radius: 50%;">
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem;">{{ $berita->penulis->nama ?? 'Administrator' }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $berita->created_at->format('d F Y') }} | <i class="far fa-eye"></i> 1,234 Views</div>
                    </div>
                </div>
            </div>

            @php
                $imgUrl = $berita->gambar_utama;
                if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                    $imgUrl = '/storage/' . $imgUrl;
                }
            @endphp

            @if($berita->gambar_utama)
                <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden;">
                    <img src="{{ $imgUrl }}" style="width: 100%; height: auto;" alt="{{ $berita->judul }}">
                    <p style="font-size: 0.8rem; color: var(--text-muted); text-align: center; margin-top: 10px; font-style: italic;">Sumber: {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }}</p>
                </div>
            @endif



            <div class="entry-content" style="font-size: 1.1rem; line-height: 1.8; color: #2d3748;">
                {!! $berita->isi !!}
            </div>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span style="font-weight: 700; font-size: 0.9rem;">TAGS:</span>
                    @foreach($berita->tags as $tag)
                        <a href="/tag/{{ $tag->slug }}" style="background: #f1f5f9; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; color: #4a5568;">#{{ $tag->nama }}</a>
                    @endforeach
                </div>
            </div>
        </article>

        <!-- Share Buttons -->
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" style="flex: 1; background: #3b5998; color: #fff; text-align: center; padding: 12px; border-radius: 8px; font-weight: 600;"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->judul) }}" target="_blank" style="flex: 1; background: #1da1f2; color: #fff; text-align: center; padding: 12px; border-radius: 8px; font-weight: 600;"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->fullUrl()) }}" target="_blank" style="flex: 1; background: #25d366; color: #fff; text-align: center; padding: 12px; border-radius: 8px; font-weight: 600;"><i class="fab fa-whatsapp"></i> WhatsApp</a>
        </div>

        <!-- Related News Section (Horizontal Grid with Thumbnails) -->
        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--border);">
            <h3 style="font-size: 1.5rem; margin-bottom: 25px; color: var(--text-main);">Berita Terkait</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                @foreach($beritaTerkait as $bt)
                <div class="related-card-premium">
                    <a href="/berita/{{ $bt->kategoris->first()->slug ?? 'umum' }}/{{ $bt->slug }}" style="text-decoration: none; color: inherit;">
                        <div style="height: 140px; border-radius: 8px; overflow: hidden; margin-bottom: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                            <img src="{{ $bt->gambar_utama ? (str_starts_with($bt->gambar_utama, 'http') ? $bt->gambar_utama : asset('storage/' . $bt->gambar_utama)) : asset('theme/pinterhukum/img/default.jpg') }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $bt->judul }}">
                        </div>
                        <h4 style="font-size: 0.95rem; line-height: 1.4; font-weight: 700; margin-bottom: 5px;">{{ Str::limit($bt->judul, 55) }}</h4>
                        <small style="color: var(--text-muted); font-size: 0.8rem;">{{ $bt->created_at->format('d M Y') }}</small>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Bagian Komentar -->
        <div id="komentar" style="margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--border);">
            <h3 style="font-size: 1.5rem; margin-bottom: 25px; color: var(--text-main);">Komentar Pembaca</h3>
            
            <!-- Form Komentar -->
            <div style="background: #f8faff; padding: 25px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #e2e8f0;">
                <h4 style="font-size: 1.1rem; margin-bottom: 15px;">Tulis Komentar</h4>
                
                @if(session('berhasil'))
                    <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        {{ session('berhasil') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <ul style="padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/komentar/kirim" method="POST">
                    @csrf
                    <input type="hidden" name="komentabel_id" value="{{ $berita->id }}">
                    <input type="hidden" name="komentabel_type" value="App\Modul\Berita\Model\Berita">
                    
                    @guest
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Nama Lengkap</label>
                            <input type="text" name="nama" placeholder="Nama Anda" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Email (Tidak dipublikasikan)</label>
                            <input type="email" name="email" placeholder="email@contoh.com" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
                        </div>
                    </div>
                    @endguest

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Isi Komentar</label>
                        <textarea name="isi" rows="4" placeholder="Tulis pendapat Anda di sini..." required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit;"></textarea>
                    </div>

                    @if(($pengaturan['captcha_aktif'] ?? '0') == '1')
                        <div style="margin-bottom: 20px;">
                             <div class="g-recaptcha" data-sitekey="{{ $pengaturan['captcha_site_key'] ?? '' }}"></div>
                             <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        </div>
                    @endif

                    <button type="submit" class="btn" style="background: var(--primary); color: #fff; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer;">Kirim Komentar</button>
                </form>
            </div>

            <!-- List Komentar -->
            @php
                $komentarList = \App\Modul\Komentar\Model\Komentar::where('komentabel_id', $berita->id)
                    ->where('komentabel_type', 'App\Modul\Berita\Model\Berita')
                    ->where('status', 'disetujui')
                    ->latest()
                    ->get();
            @endphp

            @forelse($komentarList as $k)
                <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=random" style="width: 40px; height: 40px; border-radius: 50%;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                            <span style="font-weight: 700; font-size: 0.95rem;">{{ $k->nama }}</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $k->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 0.95rem; line-height: 1.5; color: #4a5568;">{{ $k->isi }}</p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: var(--text-muted);">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            @endforelse
        </div>
    </main>

    <aside>
        <div style="position: sticky; top: 100px;">
            <div class="widget">
                <h4 class="widget-title">Top Berita</h4>
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

            @if($latestVideos->count() > 0)
            <div class="widget">
                <h4 class="widget-title">Video Terbaru</h4>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    @foreach($latestVideos as $vid)
                        @php
                            $videoId = '';
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vid->url, $match)) {
                                $videoId = $match[1];
                            }
                        @endphp
                        <div style="border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                            @if($videoId)
                                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            @else
                                <div style="padding: 15px; background: #f1f5f9; text-align: center;">
                                    <i class="fas fa-video" style="font-size: 2rem; color: #cbd5e1;"></i>
                                </div>
                            @endif
                            <div style="padding: 12px;">
                                <h5 style="font-size: 0.9rem; font-weight: 700; line-height: 1.4; margin: 0;">{{ $vid->judul }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </aside>

</div>
</div>
@endsection

@section('styles')
<style>
    .entry-content p { margin-bottom: 20px; }
    .entry-content h2, .entry-content h3 { margin: 30px 0 15px; color: var(--primary); }
    .entry-content img { max-width: 100%; height: auto; border-radius: 8px; }
    .entry-content blockquote { border-left: 4px solid var(--primary); padding-left: 20px; font-style: italic; color: var(--text-muted); margin: 30px 0; }
    .related-card-premium { transition: transform 0.2s; }
    .related-card-premium:hover { transform: translateY(-5px); }
    .related-card-premium h4:hover { color: var(--primary); }

    @media (max-width: 768px) {
        .breadcrumb-nav { display: none !important; }
        .detail-title { font-size: 1rem !important; }
    }
</style>
@endsection

@section('scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "NewsArticle",
  "headline": "{{ $berita->judul }}",
  "image": [
    "{{ $berita->gambar_utama ? asset('storage/' . $berita->gambar_utama) : asset('theme/pinterhukum/img/default.jpg') }}"
  ],
  "datePublished": "{{ $berita->created_at->toIso8601String() }}",
  "dateModified": "{{ $berita->updated_at->toIso8601String() }}",
  "author": [{
      "@@type": "Person",
      "name": "{{ $berita->penulis->nama ?? 'Admin' }}",
      "url": "{{ url('/') }}"
    }],
  "publisher": {
    "@@type": "Organization",
    "name": "{{ $pengaturan['nama_situs'] ?? 'RC Clean' }}",
    "logo": {
      "@@type": "ImageObject",
      "url": "{{ asset('logo.png') }}"
    }
  },
  "description": "{{ $berita->ringkasan }}",
  "keywords": "{{ $berita->tags->pluck('nama')->implode(', ') }}"
}
</script>
<script>
    // Breaking News Ticker Script
    let currentTicker = 0;
    const tickerItems = document.querySelectorAll('.ticker-item');
    const totalTicker = tickerItems.length;

    function showTicker(index) {
        tickerItems.forEach((item, i) => {
            if (i === index) {
                item.style.opacity = '1';
                item.style.visibility = 'visible';
                item.style.transform = 'translateY(0)';
            } else {
                item.style.opacity = '0';
                item.style.visibility = 'hidden';
                item.style.transform = 'translateY(20px)';
            }
        });
    }

    function nextTicker() {
        currentTicker = (currentTicker + 1) % totalTicker;
        showTicker(currentTicker);
    }

    function prevTicker() {
        currentTicker = (currentTicker - 1 + totalTicker) % totalTicker;
        showTicker(currentTicker);
    }

    // Auto slide every 5 seconds
    setInterval(nextTicker, 5000);
</script>
@endsection
