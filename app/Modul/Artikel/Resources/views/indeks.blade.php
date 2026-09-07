@extends('admin.layout')

@section('judul', 'Manajemen Artikel')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Artikel</h3>
        <a href="/admin/artikel/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    @if(session('berhasil'))
        <div id="artikel-success-msg" style="background: #e6fffa; color: #234e52; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($artikel as $a)
            <tr>
                <td><strong>{{ $a->judul }}</strong></td>
                <td>{{ $a->penulis->nama ?? 'Anonim' }}</td>
                <td><span class="badge badge-success">{{ $a->status }}</span></td>
                <td>{{ $a->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <button type="button" class="btn" 
                            style="padding: 5px 10px; background: #f59e0b; font-size: 0.8rem; border: none; color: #fff; cursor: pointer; border-radius: 4px;"
                            onclick="openSlidePanel('/admin/artikel/edit/{{ $a->id }}?panel=1', 'Edit Artikel')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="/admin/artikel/hapus/{{ $a->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                            @csrf
                            <button type="submit" class="btn" style="padding: 5px 10px; background: #ef4444; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada artikel.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
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
            <i class="fas fa-book-open" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;"></i>
            <span id="slide-panel-title" style="font-weight: 700; color: #fff; font-size: 0.95rem; letter-spacing: -0.02em;">Edit Artikel</span>
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
            try { $('#panel-summernote-artikel').summernote('destroy'); } catch(e) {}
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
            const val = $('#panel-summernote-artikel').summernote('code');
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
    let el = document.getElementById('artikel-success-msg');
    if (!el) {
        el = document.createElement('div');
        el.id = 'artikel-success-msg';
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
