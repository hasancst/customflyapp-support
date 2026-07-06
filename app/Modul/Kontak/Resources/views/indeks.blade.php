@extends('admin.layout')

@section('judul', 'Pesan Kontak')

@section('konten')
<div class="card">
    <h3 style="margin-bottom: 25px;">Pesan Masuk</h3>

    <table>
        <thead>
            <tr>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesan as $p)
            <tr style="{{ $p->status == 'belum_dibaca' ? 'background: rgba(78, 115, 223, 0.03); font-weight: 600;' : '' }}">
                <td>
                    <div>{{ $p->nama }}</div>
                    <small style="color: var(--text-muted);">{{ $p->email }}</small>
                </td>
                <td>{{ $p->perihal ?? '-' }}</td>
                <td>
                    @if($p->status == 'belum_dibaca')
                        <span class="badge" style="background: #fef3c7; color: #92400e;">Belum Dibaca</span>
                    @else
                        <span class="badge" style="background: #dcfce7; color: #166534;">Sudah Dibaca</span>
                    @endif
                </td>
                <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin/kontak/{{ $p->id }}" style="color: var(--primary);">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="/admin/kontak/{{ $p->id }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; padding:0;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">Tidak ada pesan masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
