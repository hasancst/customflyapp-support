@extends('admin.layout')

@section('judul', 'Manajemen Pengguna')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Pengguna</h3>
        <a href="/admin/pengguna/tambah" class="btn">
            <i class="fas fa-user-plus"></i> Tambah Pengguna
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Terdaftar Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengguna as $p)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=random" style="width: 35px; height: 35px; border-radius: 50%;">
                        <strong>{{ $p->nama }}</strong>
                    </div>
                </td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <a href="/admin/pengguna/ubah/{{ $p->id }}" style="color: var(--primary); text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/admin/pengguna/hapus/{{ $p->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
