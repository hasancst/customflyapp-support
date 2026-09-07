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

    @if(session('berhasil'))
        <div id="berita-success-msg" style="background: #e6fffa; color: #234e52; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

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
                            <button type="button"
                                onclick="openSlidePanel('/admin/berita/ubah/{{ $b->id }}?panel=1', 'Edit Berita')"
                                style="background: none; border: none; color: var(--primary); cursor: pointer; padding: 0; font-size: 1rem;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
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

{{-- ===================== SLIDE PANEL ===================== --}}
<div id="slide-panel-overlay" onclick="closeSlidePanel()" style="
    display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.45);
    z-index: 1040; backdrop-filter: blur(2px);"></div>

<div id="slide-panel" style="
    position: fixed; top: 0; right: 0; height: 100vh;
    width: 860px; max-width: 96vw;
    background: #fff; z-index: 1050;
    box-shadow: -8px 0 40px rgba(15,23,42,0.18);
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;">

    {{-- Header --}}
    <div style="
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px; height: 56px; flex-shrink: 0;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #4e73df 0%, #6366f1 100%);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-newspaper" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;"></i>
            <span id="slide-panel-title" style="font-weight: 700; color: #fff; font-size: 0.95rem; letter-spacing: -0.02em;">Edit Berita</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <button id="slide-panel-fullscreen" onclick="togglePanelFullscreen()" title="Fullscreen"
                style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
                    color: #fff; width: 32px; height: 32px; border-radius: 7px; cursor: pointer;
                    display: flex; align-items: center; justify-content: center; transition: background 0.2s;">
                <i class="fas fa-expand" id="fullscreen-icon"></i>
            </button>
            <button onclick="closeSlidePanel()" title="Tutup"
                style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
                    color: #fff; width: 32px; height: 32px; border-radius: 7px; cursor: pointer;
                    display: flex; align-items: center; justify-content: center; transition: background 0.2s;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    {{-- Body --}}
    <div id="slide-panel-body" style="flex: 1; overflow-y: auto; padding: 24px;">
        <div id="slide-panel-loader" style="display: flex; align-items: center; justify-content: center; height: 200px;">
            <div style="text-align: center; color: #94a3b8;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 12px;"></i>
                <p style="font-size: 0.85rem;">Memuat...</p>
            </div>
        </div>
        <div id="slide-panel-content" style="display: none;"></div>
    </div>

    {{-- Footer --}}
    <div id="slide-panel-footer" style="
        padding: 14px 20px; border-top: 1px solid #f1f5f9; flex-shrink: 0;
        background: #f8fafc; display: none; justify-content: space-between; align-items: center;">
        <span id="slide-panel-feedback" style="font-size: 0.82rem; color: #64748b;"></span>
        <div style="display: flex; gap: 8px;">
            <button onclick="submitPanelForm()" class="btn" style="padding: 8px 20px;">
                <i class="fas fa-save"></i> Simpan
            </button>
            <button onclick="closeSlidePanel()" class="btn" style="background: #f1f5f9; color: #64748b; padding: 8px 16px;">
                Batal
            </button>
        </div>
    </div>
</div>

<style>
    .pagination-wrapper .pagination { display: flex; gap: 5px; list-style: none; padding: 0; }
    .pagination-wrapper .page-item .page-link {
        padding: 5px 12px; border: 1px solid #e2e8f0; border-radius: 6px;
        color: #64748b; text-decoration: none; font-size: 0.85rem;
    }
    .pagination-wrapper .page-item.active .page-link { background: var(--primary); color: #fff !important; border-color: var(--primary); }
    .pagination-wrapper .page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; }

    #slide-panel.fullscreen { width: 100vw !important; max-width: 100vw !important; }
    #slide-panel.open { transform: translateX(0) !important; }
</style>

<script>
function openSlidePanel(url, title) {
    document.getElementById('slide-panel-title').textContent = title || 'Edit';
    document.getElementById('slide-panel-loader').style.display = 'flex';
    document.getElementById('slide-panel-content').style.display = 'none';
    document.getElementById('slide-panel-content').innerHTML = '';
    document.getElementById('slide-panel-feedback').textContent = '';
    document.getElementById('slide-panel-feedback').style.color = '#64748b';

    const overlay = document.getElementById('slide-panel-overlay');
    const panel = document.getElementById('slide-panel');
    overlay.style.display = 'block';
    requestAnimationFrame(() => panel.classList.add('open'));
    document.body.style.overflow = 'hidden';

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const content = document.getElementById('slide-panel-content');
            content.innerHTML = html;
            document.getElementById('slide-panel-loader').style.display = 'none';
            content.style.display = 'block';
            content.querySelectorAll('script').forEach(old => {
                const s = document.createElement('script');
                s.textContent = old.textContent;
                document.head.appendChild(s);
                document.head.removeChild(s);
            });
            document.getElementById('slide-panel-footer').style.display = 'flex';
            const form = content.querySelector('[data-panel-form]');
            if (form) form.addEventListener('submit', e => { e.preventDefault(); submitPanelForm(); });
        })
        .catch(() => {
            document.getElementById('slide-panel-loader').style.display = 'none';
            document.getElementById('slide-panel-content').innerHTML =
                '<p style="color:#ef4444;text-align:center;padding:40px;">Gagal memuat. Coba lagi.</p>';
            document.getElementById('slide-panel-content').style.display = 'block';
        });
}

function closeSlidePanel() {
    const panel = document.getElementById('slide-panel');
    const overlay = document.getElementById('slide-panel-overlay');
    panel.classList.remove('open');
    setTimeout(() => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
        if (typeof $ !== 'undefined' && $.fn.summernote) {
            try { $('#panel-editor-berita').summernote('destroy'); } catch(e) {}
        }
        document.getElementById('slide-panel-content').innerHTML = '';
        document.getElementById('slide-panel-footer').style.display = 'none';
        if (panel.classList.contains('fullscreen')) {
            panel.classList.remove('fullscreen');
            document.getElementById('fullscreen-icon').className = 'fas fa-expand';
        }
    }, 350);
}

function togglePanelFullscreen() {
    const panel = document.getElementById('slide-panel');
    const icon = document.getElementById('fullscreen-icon');
    panel.classList.toggle('fullscreen');
    icon.className = panel.classList.contains('fullscreen') ? 'fas fa-compress' : 'fas fa-expand';
}

function submitPanelForm() {
    const content = document.getElementById('slide-panel-content');
    const form = content.querySelector('[data-panel-form]');
    if (!form) return;

    // Sync summernote
    if (typeof $ !== 'undefined' && $.fn.summernote) {
        try {
            const val = $('#panel-editor-berita').summernote('code');
            if (val) $(form).find('textarea[name="isi"]').val(val);
        } catch(e) {}
    }

    const formData = new FormData(form);
    formData.append('panel', '1');

    const feedback = document.getElementById('slide-panel-feedback');
    feedback.style.color = '#64748b';
    feedback.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

    fetch(form.action, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (res.berhasil) {
            feedback.style.color = '#10b981';
            feedback.innerHTML = '<i class="fas fa-check-circle"></i> ' + res.pesan;
            setTimeout(() => {
                closeSlidePanel();
                showPageSuccess(res.pesan);
            }, 800);
        } else {
            feedback.style.color = '#ef4444';
            feedback.textContent = res.pesan || 'Terjadi kesalahan.';
        }
    })
    .catch(() => {
        feedback.style.color = '#ef4444';
        feedback.textContent = 'Gagal menghubungi server.';
    });
}

function showPageSuccess(msg) {
    let el = document.getElementById('berita-success-msg');
    if (!el) {
        el = document.createElement('div');
        el.id = 'berita-success-msg';
        el.style.cssText = 'background:#e6fffa;color:#234e52;padding:12px 16px;border-radius:10px;margin-bottom:20px;border:1px solid #b2f5ea;';
        const card = document.querySelector('.card');
        card.insertBefore(el, card.children[1]);
    }
    el.textContent = msg;
    el.style.display = 'block';
    setTimeout(() => el.style.display = 'none', 4000);
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSlidePanel(); });
</script>

@endsection
