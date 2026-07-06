@extends('admin.layout')

@section('judul', 'Chat Widgets')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Kelola Chat Widgets</h3>
        <button class="btn" onclick="document.getElementById('createModal').style.display='flex'">
            <i class="fas fa-plus"></i> Buat Widget Baru
        </button>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--bg-body); text-align: left;">
                <th style="padding: 12px;">Nama Widget</th>
                <th style="padding: 12px;">Public Key</th>
                <th style="padding: 12px;">Domain</th>
                <th style="padding: 12px;">Total Sessions</th>
                <th style="padding: 12px;">Status</th>
                <th style="padding: 12px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($widgets as $widget)
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 12px; font-weight: 600;">{{ $widget->nama }}</td>
                <td style="padding: 12px;">
                    <code style="background: var(--bg-body); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                        {{ $widget->public_key }}
                    </code>
                </td>
                <td style="padding: 12px;">{{ $widget->domain ?? '-' }}</td>
                <td style="padding: 12px;">{{ $widget->sessions_count }}</td>
                <td style="padding: 12px;">
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; background: {{ $widget->aktif ? '#10b981' : '#ef4444' }}; color: white;">
                        {{ $widget->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td style="padding: 12px;">
                    <button class="btn" style="background: #3b82f6; padding: 6px 12px; font-size: 0.9rem;" onclick="showEmbedCode('{{ $widget->public_key }}')">
                        <i class="fas fa-code"></i> Embed Code
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                    Belum ada widget. Buat widget pertama Anda!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create Widget Modal -->
<div id="createModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 20px;">Buat Widget Baru</h3>
        <form action="/admin/chat/widget/create" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nama Widget</label>
                <input type="text" name="nama" required placeholder="Contoh: Website Support">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Domain (Opsional)</label>
                <input type="url" name="domain" placeholder="https://example.com">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn">Buat Widget</button>
                <button type="button" class="btn" style="background: #64748b;" onclick="document.getElementById('createModal').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Embed Code Modal -->
<div id="embedModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="max-width: 600px; width: 90%;">
        <h3 style="margin-bottom: 20px;">Embed Code</h3>
        <p style="color: var(--text-muted); margin-bottom: 15px;">Salin kode berikut dan paste sebelum tag &lt;/body&gt; di website Anda:</p>
        <pre id="embedCode" style="background: var(--bg-body); padding: 15px; border-radius: 8px; overflow-x: auto; font-size: 0.9rem;"></pre>
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button class="btn" onclick="copyEmbedCode()"><i class="fas fa-copy"></i> Salin</button>
            <button class="btn" style="background: #64748b;" onclick="document.getElementById('embedModal').style.display='none'">Tutup</button>
        </div>
    </div>
</div>

<script>
function showEmbedCode(publicKey) {
    const code = `<script src="{{ url('/') }}/chat-widget.js"
  data-api="{{ url('/api/chat') }}"
  data-key="${publicKey}"><\/script>`;
    
    document.getElementById('embedCode').textContent = code;
    document.getElementById('embedModal').style.display = 'flex';
}

function copyEmbedCode() {
    const code = document.getElementById('embedCode').textContent;
    navigator.clipboard.writeText(code);
    alert('Kode berhasil disalin!');
}
</script>
@endsection
