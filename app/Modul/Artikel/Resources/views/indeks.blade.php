@extends('admin.layout')

@section('judul', 'Manajemen Artikel')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Artikel</h3>
        <a href="/admin/artikel/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($artikel as $a)
            <tr>
                <td><strong>{{ $a->judul }}</strong></td>
                <td>{{ $a->penulis->nama ?? 'Anonim' }}</td>
                <td><span class="badge badge-success">{{ $a->status }}</span></td>
                <td>{{ $a->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="/admin/artikel/edit/{{ $a->id }}" class="btn" style="padding: 5px 10px; background: #f59e0b; font-size: 0.8rem;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="/admin/artikel/hapus/{{ $a->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                            @csrf
                            <button type="submit" class="btn" style="padding: 5px 10px; background: #ef4444; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada artikel.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
