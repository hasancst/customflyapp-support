@extends('admin.layout')

@section('judul', 'Tambah Video')

@section('konten')
<div class="card" style="max-width: 800px;">
    <div style="margin-bottom: 25px;">
        <h3>Tambah Video Baru</h3>
    </div>

    <form action="/admin/video/simpan" method="POST">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Judul Video</label>
            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required placeholder="Contoh: Tutorial Laravel">
            @error('judul')
                <div class="invalid-feedback" style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">URL Video</label>
            <div style="display: flex; gap: 10px;">
                <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" required placeholder="https://..." style="flex: 1;">
                <button type="button" id="btn-fetch" class="btn" style="background: #0f172a; white-space: nowrap;">
                    <i class="fas fa-sync"></i> Get Data
                </button>
            </div>
            @error('url')
                <div class="invalid-feedback" style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror
            <small style="color: var(--text-muted); display: block; margin-top: 5px;">Masukkan link lengkap video (Youtube, Vimeo, dll).</small>
        </div>

        <div class="form-group">
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 20px;">
            <input type="checkbox" name="unggulan" id="unggulan" value="1">
            <label for="unggulan" style="margin-bottom: 0;">Jadikan Video Unggulan</label>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Simpan Video</button>
            <a href="/admin/video" class="btn" style="background: #f1f5f9; color: #333;">Batal</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('btn-fetch').addEventListener('click', function() {
        const url = document.getElementById('url').value;
        const btn = this;
        
        if (!url) {
            alert('Masukkan URL video terlebih dahulu!');
            return;
        }

        if (!url.includes('youtube.com') && !url.includes('youtu.be')) {
            alert('Fitur ini hanya mendukung Youtube saat ini.');
            return;
        }

        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        btn.disabled = true;

        // Use Internal Proxy to fetch data (Avoid CORS issues)
        const fetchUrl = "{{ url('/admin/video/fetch') }}?url=" + encodeURIComponent(url);
        fetch(fetchUrl)
            .then(response => {
                if (!response.ok) throw new Error('Data tidak ditemukan atau URL tidak valid');
                return response.json();
            })
            .then(data => {
                if (data.title) {
                    document.getElementById('judul').value = data.title;
                    
                    let desc = `${data.title}`;
                    if (data.author_name) {
                        desc += `\n\nChannel: ${data.author_name}`;
                    }
                    document.getElementById('keterangan').value = desc;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data video. Pastikan URL benar/publik.');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    });
</script>
@endsection
