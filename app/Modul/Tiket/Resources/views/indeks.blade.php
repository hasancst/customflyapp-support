@extends('admin.layout')

@section('judul', 'Manajemen Tiket')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;"><i class="fas fa-ticket-alt"></i> Daftar Tiket</h2>
        <div style="display: flex; gap: 10px;">
            <a href="/admin/tiket/kategori" class="btn" style="background: #64748b;"><i class="fas fa-tags"></i> Kelola Kategori</a>
            <a href="/admin/tiket/tambah" class="btn"><i class="fas fa-plus"></i> Buka Tiket Baru</a>
        </div>
    </div>

    @if(session('berhasil'))
        <div style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

    <!-- Filter -->
    <div style="margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form action="/admin/tiket" method="GET" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 250px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600; color: #64748b;">Cari Tiket</label>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari subjek atau no. tiket..." style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600; color: #64748b;">Filter Kategori</label>
                <select name="kategori_id" onchange="this.form.submit()" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('kategori_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->parent_id ? '↳ ' : '' }}{{ $cat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn"><i class="fas fa-search"></i> Cari</button>

            @if(request('kategori_id') || request('cari'))
                <a href="/admin/tiket" class="btn" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px;">No. Tiket</th>
                    <th style="padding: 15px;">Subjek</th>
                    <th style="padding: 15px;">Klien</th>
                    <th style="padding: 15px;">Prioritas</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">Dibuat</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tikets as $t)
                <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; font-weight: 700; color: #6366f1;">#{{ $t->no_tiket }}</td>
                    <td style="padding: 15px; font-weight: 600;">{{ $t->judul }}</td>
                    <td style="padding: 15px;">
                        <div>{{ $t->user->nama ?? $t->email }}</div>
                        <small style="color: #64748b;">{{ $t->kategori->nama ?? 'Tanpa Kategori' }}</small>
                    </td>
                    <td style="padding: 15px;">
                        @php
                            $pColor = ['rendah' => '#10b981', 'sedang' => '#f59e0b', 'tinggi' => '#ef4444'][$t->prioritas];
                        @endphp
                        <span style="background: {{ $pColor }}15; color: {{ $pColor }}; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                            {{ $t->prioritas }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        @php
                            $sColor = [
                                'terbuka' => '#3b82f6',
                                'proses' => '#8b5cf6',
                                'selesai' => '#10b981',
                                'ditutup' => '#64748b'
                            ][$t->status];
                        @endphp
                        <span style="background: {{ $sColor }}15; color: {{ $sColor }}; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                            {{ $t->status }}
                        </span>
                    </td>
                    <td style="padding: 15px; font-size: 0.85rem; color: #64748b;">
                        {{ $t->created_at->diffForHumans() }}
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/tiket/detail/{{ $t->id }}" style="color: #6366f1; background: #eef2ff; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="/admin/tiket/hapus/{{ $t->id }}" method="POST" onsubmit="return confirm('Hapus tiket ini?')">
                                @csrf
                                <button type="submit" style="color: #ef4444; background: #fef2f2; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 50px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                        Belum ada tiket yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 25px;">
        {{ $tikets->links() }}
    </div>
</div>
@endsection
