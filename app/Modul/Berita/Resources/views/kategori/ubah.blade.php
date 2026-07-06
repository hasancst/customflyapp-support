@extends('admin.layout')

@section('judul', 'Ubah Kategori')

@section('konten')
<div class="card" style="max-width: 500px;">
    <form action="/admin/berita/kategori/ubah/{{ $kategori->id }}" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nama Kategori</label>
            <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
        </div>
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Deskripsi</label>
            <textarea name="deskripsi" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>
        <div style="display: flex; gap: 15px; align-items: center;">
            <button type="submit" class="btn">Perbarui Kategori</button>
            <a href="/admin/berita/kategori" style="color: var(--text-muted); text-decoration: none;">Batal</a>
        </div>
    </form>
</div>
@endsection
