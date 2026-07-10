@extends('admin.layout')

@section('judul', 'Ticket Macro')

@section('konten')
<div style="display: grid; grid-template-columns: 380px 1fr; gap: 30px; align-items: start;">

    {{-- ── Add / Edit Form ─────────────────────────────────────────── --}}
    <div class="card" id="makro-form-card">
        <h3 style="margin: 0 0 20px; font-size: 1rem; color: #1e293b;" id="form-title">
            <i class="fas fa-plus-circle" style="color: #6366f1;"></i> Add Macro
        </h3>

        @if(session('berhasil'))
            <div style="background:#e6fffa;color:#234e52;padding:12px 15px;border-radius:8px;margin-bottom:18px;border:1px solid #b2f5ea;font-size:0.9rem;">
                {{ session('berhasil') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fff5f5;color:#742a2a;padding:12px 15px;border-radius:8px;margin-bottom:18px;border:1px solid #feb2b2;font-size:0.9rem;">
                {{ session('error') }}
            </div>
        @endif

        <form id="makro-form" action="/admin/tiket/makro" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="margin-bottom: 14px;">
                <label style="display:block;font-size:0.82rem;font-weight:600;color:#64748b;margin-bottom:5px;">Title <span style="color:#ef4444">*</span></label>
                <input type="text" name="judul" id="input-judul" required
                    placeholder="e.g. Welcome reply, Bug acknowledge..."
                    style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.9rem;outline:none;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display:block;font-size:0.82rem;font-weight:600;color:#64748b;margin-bottom:5px;">Template Content <span style="color:#ef4444">*</span></label>
                <textarea name="isi" id="input-isi" required rows="7"
                    placeholder="Write your reply template here..."
                    style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.9rem;resize:vertical;outline:none;font-family:inherit;"></textarea>
                <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">You can use <code>@{{name}}</code>, <code>@{{email}}</code>, <code>@{{ticket_no}}</code> as placeholders.</p>
            </div>

            <div style="display:flex;gap:15px;margin-bottom:18px;">
                <div style="flex:1;">
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#64748b;margin-bottom:5px;">Order</label>
                    <input type="number" name="urutan" id="input-urutan" value="0" min="0"
                        style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.9rem;outline:none;">
                </div>
                <div style="display:flex;align-items:flex-end;padding-bottom:3px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.9rem;font-weight:600;color:#475569;">
                        <input type="checkbox" name="aktif" id="input-aktif" checked style="width:16px;height:16px;cursor:pointer;">
                        Active
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn" style="flex:1;">
                    <i class="fas fa-save"></i> <span id="btn-label">Save Macro</span>
                </button>
                <button type="button" onclick="resetForm()" id="btn-cancel"
                    style="display:none;padding:9px 16px;background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;border-radius:8px;cursor:pointer;font-size:0.9rem;font-weight:600;">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    {{-- ── Macros List ──────────────────────────────────────────────── --}}
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:1rem;color:#1e293b;"><i class="fas fa-list" style="color:#6366f1;"></i> Macro ({{ $makros->count() }})</h3>
            <a href="/admin/tiket" style="font-size:0.85rem;color:#6366f1;"><i class="fas fa-arrow-left"></i> Back to Tickets</a>
        </div>

        @if($makros->isEmpty())
            <div style="text-align:center;padding:50px;color:#94a3b8;">
                <i class="fas fa-file-alt" style="font-size:2.5rem;margin-bottom:12px;display:block;"></i>
                No macro yet. Create one using the form.
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($makros as $m)
                <div style="border:1px solid #e2e8f0;border-radius:10px;padding:16px 18px;background:{{ $m->aktif ? '#fff' : '#f8fafc' }};">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                <span style="font-weight:700;font-size:0.95rem;color:#1e293b;">{{ $m->judul }}</span>
                                @if(!$m->aktif)
                                    <span style="background:#f1f5f9;color:#94a3b8;font-size:0.7rem;padding:2px 8px;border-radius:99px;font-weight:700;">INACTIVE</span>
                                @endif
                                <span style="background:#f1f5f9;color:#94a3b8;font-size:0.7rem;padding:2px 8px;border-radius:99px;">#{{ $m->urutan }}</span>
                            </div>
                            <p style="font-size:0.82rem;color:#64748b;margin:0;white-space:pre-line;line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;">{{ $m->isi }}</p>
                        </div>
                        <div style="display:flex;gap:6px;flex-shrink:0;">
                            <button onclick="editMakro({{ $m->id }}, {{ json_encode($m->judul) }}, {{ json_encode($m->isi) }}, {{ $m->urutan }}, {{ $m->aktif ? 'true' : 'false' }})"
                                style="padding:6px 12px;background:#eef2ff;color:#6366f1;border:1px solid #c7d2fe;border-radius:7px;cursor:pointer;font-size:0.82rem;font-weight:700;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="/admin/tiket/makro/hapus/{{ $m->id }}" method="POST"
                                onsubmit="return confirm('Delete macro \'{{ addslashes($m->judul) }}\'?')">
                                @csrf
                                <button type="submit"
                                    style="padding:6px 12px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;border-radius:7px;cursor:pointer;font-size:0.82rem;font-weight:700;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
let editingId = null;

function editMakro(id, judul, isi, urutan, aktif) {
    editingId = id;
    document.getElementById('input-judul').value  = judul;
    document.getElementById('input-isi').value    = isi;
    document.getElementById('input-urutan').value = urutan;
    document.getElementById('input-aktif').checked = aktif;

    document.getElementById('form-title').innerHTML  = '<i class="fas fa-edit" style="color:#6366f1;"></i> Edit Macro';
    document.getElementById('btn-label').textContent = 'Update Macro';
    document.getElementById('btn-cancel').style.display = 'inline-flex';

    // Change form action to update endpoint
    document.getElementById('makro-form').action = '/admin/tiket/makro/update/' + id;
    document.getElementById('form-method').value  = 'POST';

    document.getElementById('makro-form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    document.getElementById('input-judul').focus();
}

function resetForm() {
    editingId = null;
    document.getElementById('makro-form').reset();
    document.getElementById('input-aktif').checked = true;
    document.getElementById('makro-form').action   = '/admin/tiket/makro';
    document.getElementById('form-method').value   = 'POST';
    document.getElementById('form-title').innerHTML  = '<i class="fas fa-plus-circle" style="color:#6366f1;"></i> Add Macro';
    document.getElementById('btn-label').textContent = 'Save Macro';
    document.getElementById('btn-cancel').style.display = 'none';
}
</script>
@endsection
