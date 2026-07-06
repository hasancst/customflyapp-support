@extends('admin.layout')

@section('judul', 'Ubah Layanan')

@section('konten')
<div class="card" style="max-width: 800px;">
    <h3>Ubah Layanan</h3>
    <form action="/admin/layanan/ubah/{{ $item->id }}" method="POST" style="margin-top: 25px;">
        @csrf
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Layanan</label>
            <input type="text" name="judul" value="{{ $item->judul }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Ikon (FontAwesome Class)</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="ikon" id="ikonInput" value="{{ $item->ikon }}" placeholder="fas fa-code" style="flex: 1;">
                <div style="width: 45px; height: 45px; background: var(--bg-body); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border);">
                    <i id="ikonPreview" class="{{ $item->ikon ?: 'fas fa-concierge-bell' }}" style="font-size: 1.2rem; color: var(--primary);"></i>
                </div>
            </div>
            <small style="color: var(--text-muted); display: block; margin-top: 5px;">Gunakan class FontAwesome 6, contoh: <code>fas fa-laptop-code</code></small>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Deskripsi Layanan</label>
            <textarea name="deskripsi" style="height: 120px;" required>{{ $item->deskripsi }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Urutan</label>
                <input type="number" name="urutan" value="{{ $item->urutan }}">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Status</label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; margin-top: 10px;">
                    <input type="checkbox" name="aktif" value="1" {{ $item->aktif ? 'checked' : '' }}>
                    <strong>Aktifkan Layanan</strong>
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn">Perbarui Layanan</button>
            <a href="/admin/layanan" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('ikonInput').addEventListener('input', function() {
        const preview = document.getElementById('ikonPreview');
        preview.className = this.value || 'fas fa-concierge-bell';
    });
</script>
@endsection
