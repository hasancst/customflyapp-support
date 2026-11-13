@php
    $galeriArr = is_string($p->galeri ?? null) ? json_decode($p->galeri, true) : ($p->galeri ?? []);
    $rawImgs = array_slice(array_values(array_filter(array_merge([$p->gambar], is_array($galeriArr) ? $galeriArr : []))), 0, 5);
    $allImgs = array_map(fn($img) => str_starts_with($img, 'http') ? $img : '/storage/' . ltrim($img, '/'), $rawImgs);
@endphp
<div class="portfolio-item portfolio-card-5 reveal"
     data-category="{{ $p->kategori }}"
     data-title="{{ $p->judul }}"
     data-desc="{{ $p->deskripsi }}"
     data-cat="{{ $p->kategori }}"
     data-url="{{ $p->url ?? '' }}"
     data-images='@json($allImgs)'>
    <div class="pf-card-main">
        <img src="{{ $allImgs[0] ?? '/storage/' . $p->gambar }}" alt="{{ $p->judul }}" class="pf-main-img">
        @if(count($allImgs) > 1)
            <span class="portfolio-gallery-badge"><i class="fas fa-images"></i> {{ count($allImgs) }}</span>
        @endif
    </div>
    @if(count($allImgs) > 1)
    <div class="pf-card-thumbs">
        @foreach($allImgs as $tIdx => $thumbSrc)
            <button type="button" class="pf-card-thumb {{ $tIdx === 0 ? 'is-active' : '' }}" data-src="{{ $thumbSrc }}" data-idx="{{ $tIdx }}" aria-label="{{ $p->judul }} image {{ $tIdx + 1 }}">
                <img src="{{ $thumbSrc }}" alt="{{ $p->judul }} {{ $tIdx + 1 }}" loading="lazy">
            </button>
        @endforeach
    </div>
    @endif
    <div class="pf-card-info">
        @if(!empty($p->kategori))
            <span class="pf-card-cat">{{ $p->kategori }}</span>
        @endif
        <h4>{{ $p->judul }}</h4>
        <p>{{ \Illuminate\Support\Str::limit($p->deskripsi, 100) }}</p>
    </div>
</div>

