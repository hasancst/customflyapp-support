@extends('admin.layout')

@section('judul', 'Manajemen Slideshow')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Slideshow</h3>
        <a href="/admin/slideshow/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Slide
        </a>
    </div>

    @if(session('berhasil'))
        <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('berhasil') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Urutan</th>
                <th style="width: 20%;">Gambar</th>
                <th style="width: 30%;">Judul</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slideshow as $s)
            <tr>
                <td>{{ $s->urutan }}</td>
                <td>
                   <div style="margin-bottom: 10px;">
                @php
                    $imgPath = (strpos($s->gambar, 'http') === 0) ? $s->gambar : '/storage/' . $s->gambar;
                @endphp
                <img src="{{ $imgPath }}" style="width: 200px; border-radius: 8px; border: 1px solid var(--border);">
            </div>
                </td>
                <td>
                    <strong>{{ $s->judul }}</strong><br>
                    <small style="color: var(--text-muted);">{{ $s->deskripsi }}</small>
                </td>
                <td>
                    @if($s->aktif)
                        <span class="badge" style="background: #dcfce7; color: #166534;">Aktif</span>
                    @else
                        <span class="badge" style="background: #fee2e2; color: #991b1b;">Non-Aktif</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin/slideshow/ubah/{{ $s->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                        <form action="/admin/slideshow/hapus/{{ $s->id }}" method="POST" style="display:inline;">
                             @csrf
                             <button type="submit" onclick="return confirm('Hapus slide ini?')" style="border:none; background:none; color:#ef4444; cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada slideshow.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
