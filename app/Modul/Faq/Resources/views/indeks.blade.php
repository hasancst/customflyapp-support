@extends('admin.layout')

@section('judul', 'Manajemen FAQ')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar FAQ</h3>
        <a href="/admin/faq/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah FAQ
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th>Pertanyaan</th>
                    <th style="width: 10%;">Urutan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faq as $f)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $f->pertanyaan }}</strong><br>
                        <small style="color: var(--text-muted);">{{ Str::limit($f->jawaban, 100) }}</small>
                    </td>
                    <td>{{ $f->urutan }}</td>
                    <td>
                        @if($f->aktif)
                            <span class="badge" style="background: #e1f9eb; color: #166534;">Aktif</span>
                        @else
                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <a href="/admin/faq/ubah/{{ $f->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                            <form action="/admin/faq/hapus/{{ $f->id }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                @csrf
                                <button type="submit" style="border:none; background:none; color:#ef4444; cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada FAQ yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
