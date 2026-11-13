@extends('admin.layout')

@section('judul', 'Manajemen Slideshow')

@section('konten')
@if(session('berhasil'))
    <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('berhasil') }}
    </div>
@endif

<div class="card" style="margin-bottom: 24px;">
    <div style="margin-bottom: 18px;">
        <h3 style="margin-bottom: 4px;">Pengaturan 3D Rotating Slider (Homepage)</h3>
        <small style="color: var(--text-muted);">Atur teks judul, deskripsi, dan sumber gambar yang tampil pada slider 3D di homepage. Untuk mengganti/menambah gambar slide, kelola pada <strong>Daftar Slideshow</strong> di bawah.</small>
    </div>

    <form action="/admin/slideshow/pengaturan-slider" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 16px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Judul Section</label>
                <input type="text" name="slider_3d_judul" value="{{ old('slider_3d_judul', $pengaturanSlider['slider_3d_judul'] ?? 'Interactive <span>3D Showcase</span>') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px;">
                <small style="color: var(--text-muted);">Gunakan tag <code>&lt;span&gt;...&lt;/span&gt;</code> untuk warna highlight.</small>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Sumber Gambar 3D Slider</label>
                @php $sumber = old('slider_3d_sumber', $pengaturanSlider['slider_3d_sumber'] ?? 'gabungan'); @endphp
                <select name="slider_3d_sumber" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">
                    <option value="gabungan" {{ $sumber === 'gabungan' ? 'selected' : '' }}>Otomatis (Slideshow + Portfolio + Blog Unggulan)</option>
                    <option value="slideshow" {{ $sumber === 'slideshow' ? 'selected' : '' }}>Hanya dari Daftar Slideshow di bawah</option>
                </select>
                <small style="color: var(--text-muted);">Pilih "Hanya dari Daftar Slideshow" jika ingin menampilkan gambar slideshow saja.</small>
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Deskripsi / Subjudul</label>
            <input type="text" name="slider_3d_deskripsi" value="{{ old('slider_3d_deskripsi', $pengaturanSlider['slider_3d_deskripsi'] ?? 'Click any side card to bring it forward, or click the center card to open and explore.') }}" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px;">
        </div>
        <button type="submit" class="btn">
            <i class="fas fa-save"></i> Simpan Pengaturan Slider
        </button>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Slideshow</h3>
        <a href="/admin/slideshow/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Slide
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Urutan</th>
                <th style="width: 20%;">Gambar</th>
                <th style="width: 30%;">Judul</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slideshow as $s)
            <tr>
                <td>{{ $s->urutan }}</td>
                <td>
                   <div style="margin-bottom: 10px;">
                @php
                    $imgPath = (strpos($s->gambar, 'http') === 0) ? $s->gambar : '/storage/' . $s->gambar;
                @endphp
                <img src="{{ $imgPath }}" style="width: 200px; border-radius: 8px; border: 1px solid var(--border);">
            </div>
                </td>
                <td>
                    <strong>{{ $s->judul }}</strong><br>
                    <small style="color: var(--text-muted);">{{ $s->deskripsi }}</small>
                </td>
                <td>
                    @if($s->aktif)
                        <span class="badge" style="background: #dcfce7; color: #166534;">Aktif</span>
                    @else
                        <span class="badge" style="background: #fee2e2; color: #991b1b;">Non-Aktif</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin/slideshow/ubah/{{ $s->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                        <form action="/admin/slideshow/hapus/{{ $s->id }}" method="POST" style="display:inline;">
                             @csrf
                             <button type="submit" onclick="return confirm('Hapus slide ini?')" style="border:none; background:none; color:#ef4444; cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada slideshow.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
