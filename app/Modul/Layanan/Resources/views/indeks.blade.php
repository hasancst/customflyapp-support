@extends('admin.layout')

@section('judul', 'Manajemen Layanan')

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Layanan Kami</h2>
        <p style="color: var(--text-muted); margin-top: 5px;">Kelola daftar layanan yang ditawarkan perusahaan.</p>
    </div>
    <a href="/admin/layanan/tambah" class="btn">
        <i class="fas fa-plus"></i> Tambah Layanan
    </a>
</div>

@if(session('berhasil'))
<div style="background: #e1f9eb; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #bbf7d0;">
    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('berhasil') }}
</div>
@endif

<div class="card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--primary-light);">
                <th style="padding: 15px 25px; text-align: left; width: 80px;">Urutan</th>
                <th style="padding: 15px 25px; text-align: left; width: 60px;">Ikon</th>
                <th style="padding: 15px 25px; text-align: left;">Judul Layanan</th>
                <th style="padding: 15px 25px; text-align: left;">Status</th>
                <th style="padding: 15px 25px; text-align: center; width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($layanans as $l)
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 15px 25px;">{{ $l->urutan }}</td>
                <td style="padding: 15px 25px;">
                    <i class="{{ $l->ikon ?: 'fas fa-concierge-bell' }}" style="font-size: 1.2rem; color: var(--primary);"></i>
                </td>
                <td style="padding: 15px 25px;">
                    <div style="font-weight: 600;">{{ $l->judul }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">{{ Str::limit($l->deskripsi, 100) }}</div>
                </td>
                <td style="padding: 15px 25px;">
                    @if($l->aktif)
                        <span class="badge" style="background: #e1f9eb; color: #166534;">Aktif</span>
                    @else
                        <span class="badge" style="background: #fee2e2; color: #991b1b;">Non-Aktif</span>
                    @endif
                </td>
                <td style="padding: 15px 25px; text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="/admin/layanan/ubah/{{ $l->id }}" style="color: var(--primary); font-size: 1.1rem;"><i class="fas fa-edit"></i></a>
                        <form action="/admin/layanan/hapus/{{ $l->id }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem; padding: 0;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 50px; text-align: center; color: var(--text-muted);">
                    <i class="fas fa-info-circle" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                    Belum ada data layanan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
