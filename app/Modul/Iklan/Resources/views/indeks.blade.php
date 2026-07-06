@extends('admin.layout')

@section('judul', 'Manajemen Iklan')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Iklan & Banner</h3>
        <a href="/admin/iklan/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Iklan
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Preview</th>
                <th>Judul</th>
                <th>Posisi</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($iklan as $ad)
            <tr>
                <td style="width: 150px;">
                    @if($ad->jenis == 'gambar')
                        <img src="/storage/{{ $ad->konten }}" style="width: 100%; height: auto; border-radius: 6px;">
                    @else
                        <div style="background: #f1f5f9; padding: 10px; border-radius: 6px; font-family: monospace; font-size: 0.7rem; color: #64748b;">
                            SCRIPT CODE
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $ad->judul }}</strong>
                    @if($ad->link)
                        <div style="font-size: 0.8rem; color: var(--primary); margin-top: 5px;">
                            <i class="fas fa-link"></i> {{ $ad->link }}
                        </div>
                    @endif
                </td>
                <td>
                    <span class="badge" style="background: #e0f2fe; color: #0369a1;">{{ strtoupper($ad->posisi) }}</span>
                </td>
                <td>
                    {{ ucfirst($ad->jenis) }}
                </td>
                <td>
                    @if($ad->aktif)
                        <span class="badge" style="background: #dcfce7; color: #166534;">Aktif</span>
                    @else
                        <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600;">Non-Aktif</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin/iklan/ubah/{{ $ad->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                        <form action="/admin/iklan/hapus/{{ $ad->id }}" method="POST" onsubmit="return confirm('Hapus iklan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada iklan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
