@extends('admin.layout')

@section('judul', 'Manajer Modul')

@section('konten')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Daftar Modul</h3>
            <button class="btn" onclick="document.getElementById('uploadZip').click()">
                <i class="fas fa-upload"></i> Unggah ZIP Modul
            </button>
            <form id="formUpload" action="/admin/modul/unggah" method="POST" enctype="multipart/form-data" style="display: none;">
                @csrf
                <input type="file" id="uploadZip" name="file_zip" onchange="this.form.submit()">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Modul</th>
                    <th>Slug</th>
                    <th>Versi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modul as $m)
                <tr>
                    <td>
                        <strong>{{ $m['nama'] }}</strong><br>
                        <small style="color: #64748b;">{{ $m['deskripsi'] }}</small>
                    </td>
                    <td><code>{{ $m['slug'] }}</code></td>
                    <td>{{ $m['versi'] }}</td>
                    <td>
                        @if($m['terpasang'])
                            @if($m['aktif'])
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge">Nonaktif</span>
                            @endif
                        @else
                            <span class="badge">Belum Terpasang</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            @if(!$m['terpasang'])
                                <form action="/admin/modul/pasang" method="POST">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{ $m['slug'] }}">
                                    <button class="btn">Pasang</button>
                                </form>
                            @else
                                @if($m['aktif'])
                                    <form action="/admin/modul/nonaktifkan" method="POST">
                                        @csrf
                                        <input type="hidden" name="slug" value="{{ $m['slug'] }}">
                                        <button class="btn" style="background: #94a3b8;">Nonaktifkan</button>
                                    </form>
                                @else
                                    <form action="/admin/modul/aktifkan" method="POST">
                                        @csrf
                                        <input type="hidden" name="slug" value="{{ $m['slug'] }}">
                                        <button class="btn">Aktifkan</button>
                                    </form>
                                @endif
                                <form action="/admin/modul/copot" method="POST" onsubmit="return confirm('Hapus semua data modul ini?')">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{ $m['slug'] }}">
                                    <button class="btn" style="background: rgba(239, 68, 68, 0.2); color: #f87171;">Copot</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada modul yang ditemukan di folder app/Modul</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
