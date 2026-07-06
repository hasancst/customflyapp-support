@extends('admin.layout')

@section('judul', 'Daftar Artikel Knowledge Base')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;">Artikel KB</h2>
        <a href="/admin/kb/article/create" class="btn"><i class="fas fa-plus"></i> Tambah Artikel</a>
    </div>

    @if(session('berhasil'))
        <div style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px;">Judul</th>
                    <th style="padding: 12px;">Kategori</th>
                    <th style="padding: 12px;">Views</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $a)
                <tr style="border-bottom: 1px solid #f8f9fa;">
                    <td style="padding: 12px;">
                        <strong>{{ $a->judul }}</strong><br>
                        <small style="color: #64748b;">{{ $a->slug }}</small>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 5px; font-size: 12px;">{{ $a->category->nama }}</span>
                    </td>
                    <td style="padding: 12px;">{{ $a->views }}</td>
                    <td style="padding: 12px;">
                        @if($a->aktif)
                            <span style="color: #10b981; font-weight: 700;">Aktif</span>
                        @else
                            <span style="color: #ef4444; font-weight: 700;">Draft</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/kb/article/edit/{{ $a->id }}" class="btn btn-sm" style="padding: 5px 10px; font-size: 12px;">Edit</a>
                            <form action="/admin/kb/article/delete/{{ $a->id }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 5px 10px; border-radius: 5px; font-size: 12px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8;">Belum ada artikel.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $articles->links() }}
    </div>
</div>
@endsection
