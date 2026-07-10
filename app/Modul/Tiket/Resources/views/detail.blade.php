@extends('admin.layout')

@section('judul', 'Detail Tiket #' . $tiket->no_tiket)

@section('konten')
<div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
    <div>
        <!-- Judul & Info Utama -->
        <div class="card" style="margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                <div>
                    <h2 style="margin: 0; color: #1e293b;">{{ $tiket->judul }}</h2>
                    <p style="color: #64748b; margin-top: 5px;">Berasal dari: <strong>{{ $tiket->user->nama ?? $tiket->email }}</strong> &bull; {{ $tiket->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div style="text-align: right;">
                    @php
                        $sColor = [
                            'terbuka' => '#3b82f6',
                            'proses' => '#8b5cf6',
                            'selesai' => '#10b981',
                            'ditutup' => '#64748b'
                        ][$tiket->status];
                        $sLabel = [
                            'terbuka' => 'OPEN',
                            'proses' => 'IN PROGRESS',
                            'selesai' => 'RESOLVED',
                            'ditutup' => 'CLOSED'
                        ][$tiket->status] ?? strtoupper($tiket->status);
                    @endphp
                    <span style="background: {{ $sColor }}15; color: {{ $sColor }}; padding: 6px 15px; border-radius: 50px; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; border: 1px solid {{ $sColor }}30;">
                        {{ $sLabel }}
                    </span>
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 25px; border-radius: 15px; border: 1px solid #e2e8f0; line-height: 1.6; color: #334155;">
                {!! nl2br(e($tiket->pesan_awal)) !!}
            </div>

            {{-- Lampiran Tiket --}}
            @if($tiket->lampiran->count() > 0)
            <div style="margin-top: 20px;">
                <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    {{ $tiket->lampiran->count() }} Attachment
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @foreach($tiket->lampiran as $lamp)
                        @if(str_starts_with($lamp->mime_type, 'image/'))
                            <a href="{{ $lamp->url }}" target="_blank" style="display: block; border-radius: 10px; overflow: hidden; border: 2px solid #e2e8f0; transition: border-color 0.2s;" title="{{ $lamp->nama_file }}">
                                <img src="{{ $lamp->url }}" alt="{{ $lamp->nama_file }}" style="width: 120px; height: 90px; object-fit: cover; display: block;">
                            </a>
                        @else
                            <a href="{{ $lamp->url }}" target="_blank" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; text-decoration: none; color: #1e293b; font-size: 0.85rem; max-width: 220px; transition: background 0.2s;" title="{{ $lamp->nama_file }}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <div style="overflow: hidden;">
                                    <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 500;">{{ $lamp->nama_file }}</div>
                                    <div style="color: #94a3b8; font-size: 0.75rem;">PDF</div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Chat / Balasan -->
        <h3 style="margin-bottom: 20px; color: #64748b; font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-comments"></i> Percakapan
        </h3>

        @foreach($tiket->pesans as $p)
        <div style="display: flex; gap: 15px; margin-bottom: 20px; {{ $p->is_admin ? 'flex-direction: row-reverse;' : '' }}">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $p->is_admin ? '#6366f1' : '#f1f5f9' }}; color: {{ $p->is_admin ? '#fff' : '#64748b' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: 700;">
                {{ substr($p->nama_pengirim ?: '?', 0, 1) }}
            </div>
            <div style="max-width: 80%; background: {{ $p->is_admin ? '#6366f1' : '#fff' }}; color: {{ $p->is_admin ? '#fff' : '#1e293b' }}; padding: 15px 20px; border-radius: 20px; {{ $p->is_admin ? 'border-top-right-radius: 4px;' : 'border-top-left-radius: 4px; border: 1px solid #e2e8f0;' }} box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 5px; font-size: 0.8rem; opacity: 0.8;">
                    <strong>{{ $p->nama_pengirim }}</strong>
                    <span>{{ $p->created_at->diffForHumans() }}</span>
                </div>
                <div style="line-height: 1.5;">{!! nl2br(e($p->pesan)) !!}</div>
            </div>
        </div>
        @endforeach

        <!-- Form Balas -->
        @if($tiket->status != 'ditutup')
        <div class="card" style="margin-top: 40px;">
            <form action="/admin/tiket/balas/{{ $tiket->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 style="margin-bottom: 15px;">Reply Ticket</h4>

                {{-- Toolbar: Macro + KB picker --}}
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;align-items:center;">

                    {{-- Macro picker --}}
                    @if($makros->isNotEmpty())
                    <div style="display:flex;align-items:center;gap:6px;">
                        <label style="font-size:0.8rem;font-weight:600;color:#64748b;white-space:nowrap;">
                            <i class="fas fa-bolt" style="color:#6366f1;"></i> Macro:
                        </label>
                        <select id="macro-picker"
                            style="padding:6px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.85rem;background:#f8fafc;color:#475569;cursor:pointer;min-width:180px;">
                            <option value="">-- Select --</option>
                            @foreach($makros as $m)
                                <option value="{{ $m->id }}" data-isi="{{ $m->isi }}">{{ $m->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- KB article picker --}}
                    <div style="display:flex;align-items:center;gap:6px;position:relative;">
                        <label style="font-size:0.8rem;font-weight:600;color:#64748b;white-space:nowrap;">
                            <i class="fas fa-book" style="color:#0ea5e9;"></i> KB:
                        </label>
                        <div style="position:relative;">
                            <input type="text" id="kb-search" placeholder="Search article..." autocomplete="off"
                                style="padding:6px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.85rem;background:#f8fafc;color:#475569;width:200px;outline:none;">
                            <div id="kb-results"
                                style="display:none;position:absolute;top:calc(100% + 4px);left:0;width:320px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.1);z-index:200;max-height:260px;overflow-y:auto;">
                            </div>
                        </div>
                    </div>
                </div>

                <textarea id="reply-textarea" name="pesan" rows="5" placeholder="Write your reply here..." style="margin-bottom:10px;"></textarea>

                {{-- File attachment --}}
                <div style="margin-bottom:12px;">
                    <label id="attach-label"
                        style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#f1f5f9;border:1px dashed #cbd5e1;border-radius:8px;cursor:pointer;font-size:0.85rem;color:#475569;font-weight:600;transition:background 0.2s;">
                        <i class="fas fa-paperclip" style="color:#6366f1;"></i> Attach Files
                        <input type="file" name="lampiran[]" id="file-input" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.zip"
                            style="display:none;">
                    </label>
                    <div id="file-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:8px;"></div>
                    <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">Max 5 files, 10MB each. Allowed: JPG, PNG, GIF, WEBP, PDF, DOC, DOCX, ZIP</p>
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Send Reply</button>
                </div>
            </form>
        </div>
        @endif
    </div>

    <div>
        <!-- Sidebar Tiket -->
        <div class="card" style="position: sticky; top: 100px;">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Ticket Information</h3>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.8rem; color: #64748b; margin-bottom: 5px;">Priority</label>
                @php
                    $pLabel = ['rendah' => 'LOW', 'sedang' => 'MEDIUM', 'tinggi' => 'HIGH'][$tiket->prioritas] ?? strtoupper($tiket->prioritas);
                    $pColor = ['rendah' => '#10b981', 'sedang' => '#f59e0b', 'tinggi' => '#ef4444'][$tiket->prioritas];
                @endphp
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: {{ $pColor }};">
                    <i class="fas fa-circle" style="font-size: 0.6rem;"></i> {{ $pLabel }}
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.8rem; color: #64748b; margin-bottom: 5px;">Category</label>
                <div style="font-weight: 600;">{{ $tiket->tiketKategori->nama ?? 'No Category' }}</div>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 0.8rem; color: #64748b; margin-bottom: 5px;">Change Status</label>
                <form action="/admin/tiket/status/{{ $tiket->id }}" method="POST">
                    @csrf
                    <select name="status" onchange="this.form.submit()" style="padding: 8px; font-size: 0.9rem;">
                        <option value="terbuka" {{ $tiket->status == 'terbuka' ? 'selected' : '' }}>Open</option>
                        <option value="proses" {{ $tiket->status == 'proses' ? 'selected' : '' }}>In Progress</option>
                        <option value="selesai" {{ $tiket->status == 'selesai' ? 'selected' : '' }}>Resolved</option>
                        <option value="ditutup" {{ $tiket->status == 'ditutup' ? 'selected' : '' }}>Closed Permanently</option>
                    </select>
                </form>
            </div>

            <a href="/admin/tiket" class="btn btn-outline" style="width: 100%; border-color: #cbd5e1; color: #64748b; text-align: center;">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

<style>
    textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        outline: none;
        transition: 0.3s;
        resize: vertical;
    }
    textarea:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('reply-textarea');

    // ── Macro picker ────────────────────────────────────────────────────────
    const macroPicker = document.getElementById('macro-picker');
    if (macroPicker && textarea) {
        macroPicker.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const raw = selected.dataset.isi;
            if (!raw) return;

            const name     = {!! json_encode($tiket->nama ?? $tiket->email) !!};
            const email    = {!! json_encode($tiket->email) !!};
            const ticketNo = {!! json_encode($tiket->no_tiket) !!};

            const content = raw
                .replace(/\{\{name\}\}/g,      name)
                .replace(/\{\{email\}\}/g,     email)
                .replace(/\{\{ticket_no\}\}/g, ticketNo);

            textarea.value = textarea.value.trim()
                ? textarea.value + '\n\n' + content
                : content;

            this.selectedIndex = 0;
            textarea.focus();
        });
    }

    // ── KB article search ───────────────────────────────────────────────────
    const kbSearch  = document.getElementById('kb-search');
    const kbResults = document.getElementById('kb-results');

    if (kbSearch && kbResults && textarea) {
        let debounce;

        kbSearch.addEventListener('input', function () {
            clearTimeout(debounce);
            const q = this.value.trim();
            if (!q) { kbResults.style.display = 'none'; return; }

            debounce = setTimeout(async () => {
                try {
                    const res  = await fetch('/admin/kb/search?q=' + encodeURIComponent(q), {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();

                    if (!data.length) {
                        kbResults.innerHTML = '<div style="padding:12px 14px;font-size:0.85rem;color:#94a3b8;">No articles found.</div>';
                    } else {
                        kbResults.innerHTML = data.map(a => `
                            <div class="kb-item" data-url="${a.url}" data-judul="${a.judul.replace(/"/g,'&quot;')}"
                                style="padding:10px 14px;cursor:pointer;border-bottom:1px solid #f1f5f9;font-size:0.85rem;color:#1e293b;transition:background 0.15s;"
                                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                                <i class="fas fa-file-alt" style="color:#0ea5e9;margin-right:6px;"></i>${a.judul}
                            </div>`).join('');

                        // Click to insert link into textarea
                        kbResults.querySelectorAll('.kb-item').forEach(item => {
                            item.addEventListener('click', function () {
                                const link = '\n🔗 ' + this.dataset.judul + ': ' + this.dataset.url;
                                textarea.value = textarea.value.trimEnd() + link;
                                kbSearch.value = '';
                                kbResults.style.display = 'none';
                                textarea.focus();
                                textarea.scrollTop = textarea.scrollHeight;
                            });
                        });
                    }

                    kbResults.style.display = 'block';
                } catch(e) {
                    kbResults.style.display = 'none';
                }
            }, 300);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!kbSearch.contains(e.target) && !kbResults.contains(e.target)) {
                kbResults.style.display = 'none';
            }
        });
    }

    // ── File attachment preview ─────────────────────────────────────────────
    const fileInput   = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');

    if (fileInput && filePreview) {
        fileInput.addEventListener('change', function () {
            filePreview.innerHTML = '';
            const files = Array.from(this.files).slice(0, 5);

            files.forEach(file => {
                const isImg = file.type.startsWith('image/');
                const size  = file.size < 1048576
                    ? (file.size / 1024).toFixed(1) + ' KB'
                    : (file.size / 1048576).toFixed(1) + ' MB';

                const chip = document.createElement('div');
                chip.style.cssText = 'display:flex;align-items:center;gap:6px;padding:5px 10px;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;font-size:0.8rem;color:#475569;max-width:200px;';

                if (isImg) {
                    const img = document.createElement('img');
                    img.style.cssText = 'width:28px;height:28px;object-fit:cover;border-radius:4px;flex-shrink:0;';
                    img.src = URL.createObjectURL(file);
                    chip.appendChild(img);
                } else {
                    chip.innerHTML = '<i class="fas fa-file" style="color:#6366f1;flex-shrink:0;"></i>';
                }

                const label = document.createElement('span');
                label.style.cssText = 'overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;';
                label.title = file.name + ' (' + size + ')';
                label.textContent = file.name;
                chip.appendChild(label);

                const sizeSpan = document.createElement('span');
                sizeSpan.style.cssText = 'color:#94a3b8;white-space:nowrap;flex-shrink:0;';
                sizeSpan.textContent = size;
                chip.appendChild(sizeSpan);

                filePreview.appendChild(chip);
            });
        });
    }
});
</script>
@endsection
