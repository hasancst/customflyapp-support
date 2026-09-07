@extends('admin.layout')

@section('judul', 'Daftar Artikel Knowledge Base')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;">Artikel KB</h2>
        <a href="#" class="btn" onclick="openSlidePanel('/admin/kb/article/create?panel=1', 'Tambah Artikel KB'); return false;">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    @if(session('berhasil'))
        <div id="kb-success-msg" style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

    {{-- Filter Bar --}}
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px 18px; margin-bottom: 22px;">
        <form action="/admin/kb/article" method="GET" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;">

            <div style="flex: 2; min-width: 220px;">
                <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:4px;">Search</label>
                <input type="text" name="cari" id="kb-cari" value="{{ request('cari') }}"
                    placeholder="Search by title or slug..."
                    style="width:100%; padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none;">
            </div>

            <div style="flex: 1; min-width: 160px;">
                <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:4px;">Category</label>
                <select name="category_id" onchange="this.form.submit()"
                    style="width:100%; padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.88rem; background:#fff; outline:none; cursor:pointer;">
                    <option value="">-- All --</option>
                    @foreach($categoryGroups as $parent)
                        @if($parent->children->isEmpty())
                            <option value="{{ $parent->id }}" {{ request('category_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->nama }}
                            </option>
                        @else
                            <optgroup label="{{ $parent->nama }}">
                                <option value="{{ $parent->id }}" {{ request('category_id') == $parent->id ? 'selected' : '' }}>
                                    All {{ $parent->nama }}
                                </option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;↳ {{ $child->nama }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 130px;">
                <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:4px;">Status</label>
                <select name="status" onchange="this.form.submit()"
                    style="width:100%; padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.88rem; background:#fff; outline:none; cursor:pointer;">
                    <option value="">-- All --</option>
                    <option value="aktif"  {{ request('status') === 'aktif'  ? 'selected' : '' }}>Aktif</option>
                    <option value="draft"  {{ request('status') === 'draft'  ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div style="display:flex; gap:8px;">
                @if(request('cari') || request('category_id') || request('status'))
                    <a href="/admin/kb/article" class="btn"
                        style="padding:7px 14px; font-size:0.88rem; background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if(request('cari') || request('category_id') || request('status'))
        <div style="margin-top: 10px; font-size: 0.82rem; color: #64748b;">
            Showing <strong>{{ $articles->total() }}</strong> result(s)
            @if(request('cari')) for "<strong>{{ request('cari') }}</strong>"@endif
            @if(request('category_id')) in category <strong>{{ $categoryGroups->flatMap(fn($p) => $p->children->prepend($p))->firstWhere('id', request('category_id'))?->nama }}</strong>@endif
            @if(request('status')) · status: <strong>{{ request('status') }}</strong>@endif
        </div>
        @endif
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px;">Judul</th>
                    <th style="padding: 12px;">Kategori</th>
                    <th style="padding: 12px;">Views</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $a)
                <tr style="border-bottom: 1px solid #f8f9fa;" id="kb-row-{{ $a->id }}">
                    <td style="padding: 12px;">
                        <strong>{{ $a->judul }}</strong><br>
                        <small style="color: #64748b;">{{ $a->slug }}</small>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 5px; font-size: 12px;">{{ $a->category->nama }}</span>
                    </td>
                    <td style="padding: 12px;">{{ $a->views }}</td>
                    <td style="padding: 12px;">
                        @if($a->aktif)
                            <span style="color: #10b981; font-weight: 700;">Aktif</span>
                        @else
                            <span style="color: #ef4444; font-weight: 700;">Draft</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn btn-sm"
                                style="padding: 5px 10px; font-size: 12px;"
                                onclick="openSlidePanel('/admin/kb/article/edit/{{ $a->id }}?panel=1', 'Edit Artikel KB')">
                                Edit
                            </button>
                            <form action="/admin/kb/article/delete/{{ $a->id }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 5px 10px; border-radius: 5px; font-size: 12px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8;">Belum ada artikel.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px; display: flex; justify-content: center;">
        <div class="pagination-wrapper">
            {{ $articles->links() }}
        </div>
    </div>
</div>

{{-- ===================== SLIDE PANEL ===================== --}}
<div id="slide-panel-overlay" onclick="closeSlidePanel()" style="
    display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.45);
    z-index: 1040; backdrop-filter: blur(2px); transition: opacity 0.3s;"></div>

<div id="slide-panel" style="
    position: fixed; top: 0; right: 0; height: 100vh;
    width: 820px; max-width: 96vw;
    background: #fff; z-index: 1050;
    box-shadow: -8px 0 40px rgba(15,23,42,0.18);
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;">

    {{-- Panel Header --}}
    <div style="
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px; height: 56px; flex-shrink: 0;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #4e73df 0%, #6366f1 100%);">

        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-pencil-alt" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;"></i>
            <span id="slide-panel-title" style="font-weight: 700; color: #fff; font-size: 0.95rem; letter-spacing: -0.02em;">Edit</span>
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            {{-- Fullscreen Toggle --}}
            <button id="slide-panel-fullscreen" onclick="togglePanelFullscreen()" title="Fullscreen"
                style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
                    color: #fff; width: 32px; height: 32px; border-radius: 7px; cursor: pointer;
                    display: flex; align-items: center; justify-content: center;
                    transition: background 0.2s;">
                <i class="fas fa-expand" id="fullscreen-icon"></i>
            </button>
            {{-- Close --}}
            <button onclick="closeSlidePanel()" title="Tutup"
                style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
                    color: #fff; width: 32px; height: 32px; border-radius: 7px; cursor: pointer;
                    display: flex; align-items: center; justify-content: center;
                    transition: background 0.2s;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    {{-- Panel Body --}}
    <div id="slide-panel-body" style="flex: 1; overflow-y: auto; padding: 24px;">
        <div id="slide-panel-loader" style="display: flex; align-items: center; justify-content: center; height: 200px;">
            <div style="text-align: center; color: #94a3b8;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 12px;"></i>
                <p style="font-size: 0.85rem;">Memuat...</p>
            </div>
        </div>
        <div id="slide-panel-content" style="display: none;"></div>
    </div>

    {{-- Panel Footer --}}
    <div id="slide-panel-footer" style="
        padding: 14px 20px; border-top: 1px solid #f1f5f9; flex-shrink: 0;
        background: #f8fafc; display: flex; justify-content: space-between; align-items: center; display: none;">
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
.pagination-wrapper .pagination {
    display: flex; gap: 5px; list-style: none; padding: 0; margin: 0;
}
.pagination-wrapper .page-item .page-link {
    padding: 6px 13px; border: 1px solid #e2e8f0; border-radius: 8px;
    color: #475569; background: #fff; font-size: 0.85rem; text-decoration: none; transition: background 0.15s;
}
.pagination-wrapper .page-item .page-link:hover { background: #f1f5f9; }
.pagination-wrapper .page-item.active .page-link { background: #6366f1; border-color: #6366f1; color: #fff; }
.pagination-wrapper .page-item.disabled .page-link { color: #cbd5e1; pointer-events: none; }

#slide-panel.fullscreen {
    width: 100vw !important;
    max-width: 100vw !important;
}
#slide-panel-overlay.active { display: block !important; }
#slide-panel.open { transform: translateX(0) !important; }

#slide-panel-fullscreen:hover,
#slide-panel .close-btn:hover { background: rgba(255,255,255,0.25) !important; }
</style>

<script>
let currentPanelUrl = null;

function openSlidePanel(url, title) {
    currentPanelUrl = url;
    document.getElementById('slide-panel-title').textContent = title || 'Edit';
    document.getElementById('slide-panel-loader').style.display = 'flex';
    document.getElementById('slide-panel-content').style.display = 'none';
    document.getElementById('slide-panel-content').innerHTML = '';
    document.getElementById('slide-panel-feedback').textContent = '';

    // Show overlay + panel
    const overlay = document.getElementById('slide-panel-overlay');
    const panel = document.getElementById('slide-panel');
    overlay.style.display = 'block';
    requestAnimationFrame(() => {
        overlay.style.opacity = '1';
        panel.classList.add('open');
    });
    document.body.style.overflow = 'hidden';

    // Fetch content
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const content = document.getElementById('slide-panel-content');
            content.innerHTML = html;
            document.getElementById('slide-panel-loader').style.display = 'none';
            content.style.display = 'block';

            // Execute scripts inside fetched HTML
            content.querySelectorAll('script').forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.textContent = oldScript.textContent;
                document.head.appendChild(newScript);
                document.head.removeChild(newScript);
            });

            // Show footer
            document.getElementById('slide-panel-footer').style.display = 'flex';

            // Handle panel form submit via AJAX
            const form = content.querySelector('[data-panel-form]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitPanelForm();
                });
            }
        })
        .catch(() => {
            document.getElementById('slide-panel-loader').style.display = 'none';
            document.getElementById('slide-panel-content').innerHTML =
                '<p style="color:#ef4444; text-align:center; padding: 40px;">Gagal memuat konten. Silakan coba lagi.</p>';
            document.getElementById('slide-panel-content').style.display = 'block';
        });
}

function closeSlidePanel() {
    const overlay = document.getElementById('slide-panel-overlay');
    const panel = document.getElementById('slide-panel');
    panel.classList.remove('open');
    overlay.style.opacity = '0';
    setTimeout(() => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
        // Destroy summernote if active
        if (typeof $ !== 'undefined' && $.fn.summernote) {
            try { $('#panel-summernote-kb').summernote('destroy'); } catch(e) {}
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

    // Sync summernote content
    if (typeof $ !== 'undefined' && $.fn.summernote) {
        try {
            const sn = $(form).find('.note-editable').closest('.note-editor');
            if (sn.length) {
                const textarea = $(form).find('textarea[name="konten"]');
                textarea.val($('#panel-summernote-kb').summernote('code'));
            }
        } catch(e) {}
    }

    const formData = new FormData(form);
    formData.append('panel', '1');

    const feedback = document.getElementById('slide-panel-feedback');
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
                // Show success on page
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
    let el = document.getElementById('kb-success-msg');
    if (!el) {
        el = document.createElement('div');
        el.id = 'kb-success-msg';
        el.style.cssText = 'background:#e6fffa;color:#234e52;padding:15px;border-radius:10px;margin-bottom:25px;border:1px solid #b2f5ea;';
        const card = document.querySelector('.card');
        card.insertBefore(el, card.children[1]);
    }
    el.textContent = msg;
    el.style.display = 'block';
    setTimeout(() => el.style.display = 'none', 4000);
}

// ESC key to close
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSlidePanel(); });

// Auto-submit search after user stops typing (400ms debounce)
(function () {
    const input = document.getElementById('kb-cari');
    if (!input) return;
    let timer;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => this.form.submit(), 400);
    });
})();
</script>
@endsection
