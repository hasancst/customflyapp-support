@extends('admin.layout')

@section('judul', 'Manajemen Berita')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Berita</h3>
        <div style="display: flex; gap: 10px;">
            <a href="/admin/berita/import-wp" class="btn" style="background: #eab308;">
                <i class="fab fa-wordpress"></i> Import WP
            </a>
            <a href="/admin/berita/kategori" class="btn" style="background: #64748b;">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="/admin/berita/tambah" class="btn">
                <i class="fas fa-plus"></i> Buat Berita
            </a>
        </div>
    </div>

    <div style="background: #f8fafc; padding: 15px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #e2e8f0;">
        <form action="/admin/berita" method="GET" style="display: flex; gap: 15px; align-items: flex-end;">
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 5px;">Cari Berita</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul berita..." style="padding: 8px 12px; font-size: 0.9rem; width: 100%; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
            <div style="width: 200px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 5px;">Kategori</label>
                <select name="kategori" style="padding: 8px 12px; font-size: 0.9rem; width: 100%; border: 1px solid #cbd5e1; border-radius: 8px;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn">
                <i class="fas fa-search"></i> Filter
            </button>
            @if(request()->filled('search') || request()->filled('kategori'))
                <a href="/admin/berita" class="btn" style="background: #94a3b8;">Reset</a>
            @endif
        </form>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">SAMPUL</th>
                    <th>JUDUL</th>
                    <th>KATEGORI (CEPAT)</th>
                    <th>PENULIS</th>
                    <th>TANGGAL</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($berita as $b)
                <tr>
                    <td>
                        @if($b->gambar_utama)
                            @php
                                $imgUrl = $b->gambar_utama;
                                if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                                    $imgUrl = '/storage/' . $imgUrl;
                                }
                            @endphp
                            <img src="{{ $imgUrl }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        @else
                            <div style="width: 60px; height: 40px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <i class="fas fa-image" style="font-size: 0.8rem;"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column;">
                            <strong style="color: var(--text-main); font-size: 0.95rem;">
                                {{ $b->judul }}
                                @if($b->unggulan)
                                    <i class="fas fa-star" style="color: #f59e0b; margin-left: 5px; font-size: 0.8rem;" title="Berita Unggulan"></i>
                                @endif
                            </strong>
                            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 3px;">{{ str($b->ringkasan)->limit(50) }}</small>
                        </div>
                    </td>
                    <td>
                        <form action="/admin/berita/quick-kategori/{{ $b->id }}" method="POST" id="form-kat-{{ $b->id }}">
                            @csrf
                            <select name="kategori_ids[]" onchange="document.getElementById('form-kat-{{ $b->id }}').submit()" style="padding: 4px 8px; font-size: 0.8rem; border-radius: 6px; border: 1px solid #cbd5e1; width: 100%; cursor: pointer;">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ $b->kategoris->contains($kat->id) ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </form>
                        <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 5px;">
                            @foreach($b->tags as $tag)
                                <span style="font-size: 0.7rem; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px;">#{{ $tag->nama }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($b->penulis->nama ?? 'A') }}&size=24&background=random" style="width: 24px; height: 24px; border-radius: 50%;">
                            <span style="font-size: 0.85rem;">{{ $b->penulis->nama ?? 'Anonim' }}</span>
                        </div>
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);">
                        {{ $b->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <form action="/admin/berita/unggulan/{{ $b->id }}" method="POST">
                                @csrf
                                <button type="submit" style="background:none; border:none; color:{{ $b->unggulan ? '#f59e0b' : '#cbd5e1' }}; cursor:pointer; padding:0; font-size: 1rem;" title="{{ $b->unggulan ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}">
                                    <i class="{{ $b->unggulan ? 'fas' : 'far' }} fa-star"></i>
                                </button>
                            </form>
                            <a href="/admin/berita/ubah/{{ $b->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                            <form action="/admin/berita/hapus/{{ $b->id }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; padding:0;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada berita.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: center;">
        <div class="pagination-wrapper">
            {{ $berita->links() }}
        </div>
    </div>
</div>

<style>
    .pagination-wrapper .pagination {
        display: flex;
        gap: 5px;
        list-style: none;
        padding: 0;
    }
    .pagination-wrapper .page-item .page-link {
        padding: 5px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .pagination-wrapper .page-item.active .page-link {
        background: var(--primary);
        color: #fff !important;
        border-color: var(--primary);
    }
    .pagination-wrapper .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection
