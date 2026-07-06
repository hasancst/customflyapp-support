@extends('admin.layout')

@section('judul', 'Ubah Pengguna')

@section('konten')
<div class="card" style="max-width: 600px;">
    <form action="/admin/pengguna/ubah/{{ $user->id }}" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
        </div>
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Kata Sandi Baru (Kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="kata_sandi">
            @error('kata_sandi') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>
        <div style="display: flex; gap: 15px; align-items: center;">
            <button type="submit" class="btn">Perbarui Pengguna</button>
            <a href="/admin/pengguna" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Batal</a>
        </div>
    </form>
</div>
@endsection
