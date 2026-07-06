@extends('admin.layout')

@section('judul', 'Ubah Video')

@section('konten')
<div class="card" style="max-width: 800px;">
    <div style="margin-bottom: 25px;">
        <h3>Ubah Video</h3>
    </div>

    <form action="/admin/video/perbarui/{{ $video->id }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Judul Video</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ $video->judul }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">URL Video</label>
            <div style="display: flex; gap: 10px;">
                <input type="url" name="url" id="url" class="form-control" value="{{ $video->url }}" required style="flex: 1;">
                <button type="button" id="btn-fetch" class="btn" style="background: #0f172a; white-space: nowrap;">
                    <i class="fas fa-sync"></i> Get Data
                </button>
            </div>
            <small style="color: var(--text-muted); display: block; margin-top: 5px;">Masukkan link lengkap video (Youtube, Vimeo, dll).</small>
        </div>

        <div class="form-group">
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $video->keterangan }}</textarea>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 20px; margin-top: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="aktif" id="aktif" value="1" {{ $video->aktif ? 'checked' : '' }}>
                <label for="aktif" style="margin-bottom: 0;">Aktifkan Video</label>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="unggulan" id="unggulan" value="1" {{ $video->unggulan ? 'checked' : '' }}>
                <label for="unggulan" style="margin-bottom: 0;">Jadikan Video Unggulan</label>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Perbarui Video</button>
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
