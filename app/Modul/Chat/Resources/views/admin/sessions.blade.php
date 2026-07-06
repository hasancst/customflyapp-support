@extends('admin.layout')

@section('judul', 'Chat Sessions')

@section('konten')
<div class="card">
    <h3 style="margin-bottom: 25px;">Riwayat Chat Sessions</h3>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--bg-body); text-align: left;">
                <th style="padding: 12px;">Pengunjung</th>
                <th style="padding: 12px;">Email</th>
                <th style="padding: 12px;">Widget</th>
                <th style="padding: 12px;">Status</th>
                <th style="padding: 12px;">Tiket</th>
                <th style="padding: 12px;">Waktu</th>
                <th style="padding: 12px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 12px; font-weight: 600;">{{ $session->nama_pengunjung ?? 'Anonymous' }}</td>
                <td style="padding: 12px;">{{ $session->email_pengunjung ?? '-' }}</td>
                <td style="padding: 12px;">{{ $session->widget->nama }}</td>
                <td style="padding: 12px;">
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; background: {{ $session->status === 'aktif' ? '#3b82f6' : ($session->status === 'eskalasi' ? '#f59e0b' : '#10b981') }}; color: white;">
                        {{ ucfirst($session->status) }}
                    </span>
                </td>
                <td style="padding: 12px;">
                    @if($session->tiket)
                        <a href="/admin/tiket/{{ $session->tiket->id }}" style="color: var(--primary);">
                            #{{ $session->tiket->id }}
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td style="padding: 12px;">{{ $session->created_at->diffForHumans() }}</td>
                <td style="padding: 12px;">
                    <a href="/admin/chat/session/{{ $session->id }}" class="btn" style="background: #3b82f6; padding: 6px 12px; font-size: 0.9rem;">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 40px; text-align: center; color: var(--text-muted);">
                    Belum ada chat session.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $sessions->links() }}
    </div>
</div>
@endsection
