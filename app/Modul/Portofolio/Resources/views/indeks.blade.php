@extends('admin.layout')

@section('judul', 'Manajemen Portofolio')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Portofolio</h3>
        <a href="/admin/portofolio/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Portofolio
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">Gambar</th>
                    <th>Judul / Proyek</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($portofolio as $p)
                <tr>
                    <td>{{ $p->urutan }}</td>
                    <td>
                        @php
                            $imgPath = (strpos($p->gambar, 'http') === 0) ? $p->gambar : '/storage/' . $p->gambar;
                        @endphp
                        <img src="{{ $imgPath }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td>
                        <strong>{{ $p->judul }}</strong><br>
                        <small style="color: var(--text-muted);">Klien: {{ $p->klien ?? '-' }}</small>
                    </td>
                    <td><span class="badge">{{ $p->kategori ?? 'Umum' }}</span></td>
                    <td>
                        @if($p->aktif)
                            <span class="badge" style="background: #e1f9eb; color: #166534;">Aktif</span>
                        @else
                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <a href="/admin/portofolio/ubah/{{ $p->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                            <form action="/admin/portofolio/hapus/{{ $p->id }}" method="POST" onsubmit="return confirm('Hapus portofolio ini?')">
                                @csrf
                                <button type="submit" style="border:none; background:none; color:#ef4444; cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada portofolio yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
