@extends('admin.layout')

@section('judul', 'Manajemen Video')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3>Daftar Video Youtube</h3>
        <a href="/admin/video/tambah" class="btn">
            <i class="fas fa-plus"></i> Tambah Video
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Judul</th>
                <th style="width: 40%;">URL Video</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($video as $v)
            <tr>
                <td>{{ $v->judul }}</td>
                <td>
                    <a href="{{ $v->url }}" target="_blank" style="color: var(--primary); word-break: break-all;">{{ $v->url }}</a>
                </td>
                <td>
                    @if($v->unggulan)
                        <span class="badge" style="background: #fef3c7; color: #b45309; margin-bottom: 5px; display: inline-block;">
                            <i class="fas fa-star"></i> Featured
                        </span><br>
                    @endif

                    @if($v->aktif)
                        <span class="badge" style="background: #dcfce7; color: #166534;">Aktif</span>
                    @else
                        <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600;">Non-Aktif</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin/video/ubah/{{ $v->id }}" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                        <a href="/admin/video/hapus/{{ $v->id }}" onclick="return confirm('Hapus video ini?')" style="color:#ef4444;"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada video.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
