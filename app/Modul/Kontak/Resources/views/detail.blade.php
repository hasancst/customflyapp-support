@extends('admin.layout')

@section('judul', 'Detail Pesan')

@section('konten')
<div class="card" style="max-width: 800px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
        <div>
            <h2 style="margin-bottom: 5px;">{{ $pesan->perihal ?? 'Tanpa Perihal' }}</h2>
            <p style="color: var(--text-muted);">Dari: <strong>{{ $pesan->nama }}</strong> &lt;{{ $pesan->email }}&gt;</p>
        </div>
        <div style="text-align: right;">
            <p style="font-size: 0.85rem; color: var(--text-muted);">{{ $pesan->created_at->format('d F Y, H:i') }}</p>
            <span class="badge" style="{{ $pesan->status == 'belum_dibaca' ? 'background: #fef3c7; color: #92400e;' : 'background: #dcfce7; color: #166534;' }}">
                {{ $pesan->status == 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
            </span>
        </div>
    </div>

    <div style="background: #f8fafc; padding: 25px; border-radius: 12px; line-height: 1.6; white-space: pre-wrap; margin-bottom: 30px;">
{{ $pesan->pesan }}
    </div>

    <div style="display: flex; gap: 15px;">
        <a href="mailto:{{ $pesan->email }}" class="btn">
            <i class="fas fa-reply"></i> Balas ke Pengirim
        </a>
        <a href="/admin/kontak" style="padding: 10px 20px; text-decoration: none; color: var(--text-muted); border: 1px solid var(--border); border-radius: 10px; font-weight: 600;">
            Kembali
        </a>
        <form action="/admin/kontak/{{ $pesan->id }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')" style="margin-left: auto;">
            @csrf @method('DELETE')
            <button type="submit" style="background: #fff; border: 1px solid #fee2e2; color: #ef4444; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-trash"></i> Hapus Pesan
            </button>
        </form>
    </div>
</div>
@endsection
