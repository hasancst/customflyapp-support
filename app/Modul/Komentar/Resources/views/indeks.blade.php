@extends('admin.layout')

@section('judul', 'Moderasi Komentar')

@section('konten')
<div class="card">
    <h3 style="margin-bottom: 25px;">Komentar Terbaru</h3>

    <table>
        <thead>
            <tr>
                <th style="width: 200px;">Pengirim</th>
                <th>Komentar</th>
                <th>Konten (Tipe)</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($komentar as $k)
            <tr>
                <td>
                    <div style="font-weight: 600;">{{ $k->nama_pengirim }}</div>
                    <small style="color: var(--text-muted);">{{ $k->email ?? ($k->user->email ?? '-') }}</small>
                    <div style="font-size: 0.75rem; color: #94a3b8; mt-1">{{ $k->created_at->diffForHumans() }}</div>
                </td>
                <td>
                    <div style="font-size: 0.9rem; line-height: 1.5; color: var(--text-main);">{{ $k->isi }}</div>
                    <small style="color: var(--text-muted); font-size: 0.75rem;">IP: {{ $k->ip_address }}</small>
                </td>
                <td>
                    <div style="font-size: 0.85rem; font-weight: 500;">{{ $k->komentabel->judul ?? 'Konten Terhapus' }}</div>
                    <span class="badge" style="background: #f1f5f9; color: #64748b; font-size: 0.65rem;">
                        {{ class_basename($k->komentabel_type) }}
                    </span>
                </td>
                <td>
                    @if($k->status == 'pending')
                        <span class="badge" style="background: #fef3c7; color: #92400e;">Pending</span>
                    @elseif($k->status == 'disetujui')
                        <span class="badge" style="background: #dcfce7; color: #166534;">Disetujui</span>
                    @else
                        <span class="badge" style="background: #fee2e2; color: #b91c1c;">Spam</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        @if($k->status != 'disetujui')
                            <form action="/admin/komentar/setujui/{{ $k->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="padding: 5px 10px; font-size: 0.75rem; background: #22c55e;" title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif

                        @if($k->status != 'spam')
                            <form action="/admin/komentar/spam/{{ $k->id }}" method="POST">
                                @csrf
                                <button type="submit" style="background: #f59e0b; border: none; color: white; padding: 5px 10px; border-radius: 8px; cursor: pointer; font-size: 0.75rem;" title="Tandai Spam">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            </form>
                        @endif

                        <form action="/admin/komentar/hapus/{{ $k->id }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: #ef4444; border: none; color: white; padding: 5px 10px; border-radius: 8px; cursor: pointer; font-size: 0.75rem;" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">Belum ada komentar masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
