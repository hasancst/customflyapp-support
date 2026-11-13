@extends('admin.layout')

@section('judul', 'Manajemen Layanan')

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Layanan Kami</h2>
        <p style="color: var(--text-muted); margin-top: 5px;">Kelola daftar layanan yang ditawarkan perusahaan.</p>
    </div>
    <a href="/admin/layanan/tambah" class="btn">
        <i class="fas fa-plus"></i> Tambah Layanan
    </a>
</div>

@if(session('berhasil'))
<div style="background: #e1f9eb; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #bbf7d0;">
    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('berhasil') }}
</div>
@endif

@if($errors->any())
<div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #fecaca;">
    <ul style="margin: 0; padding-left: 18px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card" style="margin-bottom: 30px; padding: 25px;">
    <div style="margin-bottom: 20px;">
        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 4px;">Pengaturan Complete 3-Suite Platform (Homepage)</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Ubah teks, checklist fitur, link tombol, dan gambar untuk 3 blok showcase (Customfly, Uploadfly, Optionfly) di homepage.</p>
    </div>

    <form action="/admin/layanan/pengaturan-suite" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 22px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Eyebrow Section</label>
                <input type="text" name="suite_eyebrow" value="{{ old('suite_eyebrow', $suiteEyebrow) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Judul Utama Section</label>
                <input type="text" name="suite_title" value="{{ old('suite_title', $suiteTitle) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
        </div>

        @foreach($suites as $idx => $s)
        <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 18px; background: #fafbfc;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                <strong style="font-size: 1rem; color: {{ $s['color'] ?? '#2563eb' }};">Suite #{{ $idx + 1 }}</strong>
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.88rem; cursor: pointer;">
                    <input type="checkbox" name="suites[{{ $idx }}][reversed]" value="1" {{ !empty($s['reversed']) ? 'checked' : '' }}>
                    Posisi gambar di kiri (teks di kanan)
                </label>
            </div>

            <input type="hidden" name="suites[{{ $idx }}][color]" value="{{ $s['color'] ?? '#38bdf8' }}">
            <input type="hidden" name="suites[{{ $idx }}][existing_image]" value="{{ $s['image'] ?? '' }}">

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Sub-judul / Eyebrow</label>
                    <input type="text" name="suites[{{ $idx }}][eyebrow]" value="{{ $s['eyebrow'] ?? '' }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Judul Suite</label>
                    <input type="text" name="suites[{{ $idx }}][title]" value="{{ $s['title'] ?? '' }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Deskripsi</label>
                <textarea name="suites[{{ $idx }}][desc]" rows="2" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">{{ $s['desc'] ?? '' }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Checklist Fitur (1 poin per baris)</label>
                    <textarea name="suites[{{ $idx }}][chips]" rows="4" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">{{ implode("\n", $s['chips'] ?? []) }}</textarea>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Teks Tombol CTA</label>
                        <input type="text" name="suites[{{ $idx }}][cta]" value="{{ $s['cta'] ?? '' }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">URL Tombol CTA</label>
                        <input type="text" name="suites[{{ $idx }}][url]" value="{{ $s['url'] ?? '' }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                @if(!empty($s['image']))
                    <img src="{{ $s['image'] }}" alt="Preview" style="width: 140px; height: 84px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); background: #fff;">
                @endif
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Ganti Gambar (opsional)</label>
                    <input type="file" name="suite_image_{{ $idx }}" accept="image/*" style="font-size: 0.88rem;">
                </div>
            </div>
        </div>
        @endforeach

        <button type="submit" class="btn">
            <i class="fas fa-save"></i> Simpan Pengaturan 3-Suite Platform
        </button>
    </form>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--primary-light);">
                <th style="padding: 15px 25px; text-align: left; width: 80px;">Urutan</th>
                <th style="padding: 15px 25px; text-align: left; width: 60px;">Ikon</th>
                <th style="padding: 15px 25px; text-align: left;">Judul Layanan</th>
                <th style="padding: 15px 25px; text-align: left;">Status</th>
                <th style="padding: 15px 25px; text-align: center; width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($layanans as $l)
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 15px 25px;">{{ $l->urutan }}</td>
                <td style="padding: 15px 25px;">
                    <i class="{{ $l->ikon ?: 'fas fa-concierge-bell' }}" style="font-size: 1.2rem; color: var(--primary);"></i>
                </td>
                <td style="padding: 15px 25px;">
                    <div style="font-weight: 600;">{{ $l->judul }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">{{ Str::limit($l->deskripsi, 100) }}</div>
                </td>
                <td style="padding: 15px 25px;">
                    @if($l->aktif)
                        <span class="badge" style="background: #e1f9eb; color: #166534;">Aktif</span>
                    @else
                        <span class="badge" style="background: #fee2e2; color: #991b1b;">Non-Aktif</span>
                    @endif
                </td>
                <td style="padding: 15px 25px; text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="/admin/layanan/ubah/{{ $l->id }}" style="color: var(--primary); font-size: 1.1rem;"><i class="fas fa-edit"></i></a>
                        <form action="/admin/layanan/hapus/{{ $l->id }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem; padding: 0;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 50px; text-align: center; color: var(--text-muted);">
                    <i class="fas fa-info-circle" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                    Belum ada data layanan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
